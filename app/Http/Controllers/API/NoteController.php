<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\NoteResource;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller {
    /**
     * @OA\Get(
     *     path="/api/notes/index",
     *     summary="Get list of my notes",
     *     tags={"Notes"},
     *     	 @OA\Parameter(
     *         description="page",
     *         in="query",
     *         name="page",
     *         required=false,
     *
     *         @OA\Schema(type="integer"),
     *     ),
     *
     *     @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     *     @OA\Response(response=204, description="Successful"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     *     @OA\Response(response=422, description="Unprocessable Content", @OA\JsonContent()),
     *     security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     */
    public function index ( Request $request ) {
        $request->validate([
                               'page' => [ 'nullable' ] ,
                           ]);
        $user = Auth::user();
        $notes = Note::query()
                     ->where('user_id' , $user->id)
                     ->latest()
                     ->simplePaginate(12);

        return response()->json([
                                    'notes' => NoteResource::collection($notes->items()) ,
                                    'current_page' => $notes->currentPage() ,
                                    'next_page_url' => $notes->nextPageUrl() ,
                                    'previous_page_url' => $notes->previousPageUrl() ,
                                    'per_page' => $notes->perPage() ,
                                ]);
    }

    /**
     * @OA\Post(
     *     path="/api/notes/store",
     *     summary="Store new note",
     *     tags={"Notes"},
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\MediaType(
     *             mediaType="application/json",
     *
     *             @OA\Schema(
     *
     *                 @OA\Property(
     *                     property="body",
     *                     type="string",
     *                     example="My note body",
     *                     description=""
     *                 ),
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     *     @OA\Response(response=204, description="Successful"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     *     @OA\Response(response=422, description="Unprocessable Content", @OA\JsonContent()),
     *     security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     */
    public function store ( Request $request ) {
        $request->validate([
                               'body' => [ 'required' ] ,
                           ]);
        Note::query()
            ->create([
                         'user_id' => Auth::user()->id ,
                         'body' => $request->body ,
                     ]);

        return response()->json([
                                    'status' => true ,
                                    'message' => 'یادداشت با موفقیت ذخیره شد.' ,
                                ]);
    }

    /**
     * @OA\Put(
     *     path="/api/notes/update/{id}",
     *     summary="Update a note",
     *     tags={"Notes"},
     *     	 @OA\Parameter(
     *         description="id",
     *         in="path",
     *         name="id",
     *         required=false,
     *
     *         @OA\Schema(type="integer"),
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\MediaType(
     *             mediaType="application/json",
     *
     *             @OA\Schema(
     *
     *                 @OA\Property(
     *                     property="body",
     *                     type="string",
     *                     example="My note body",
     *                     description=""
     *                 ),
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     *     @OA\Response(response=204, description="Successful"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     *     @OA\Response(response=422, description="Unprocessable Content", @OA\JsonContent()),
     *     security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     */
    public function update ( Request $request , $id ) {
        $request->validate([
                               'body' => [ 'required' ] ,
                           ]);
        $note = Note::query()
                    ->where('user_id' , Auth::user()->id)
                    ->where('id' , $id)
                    ->firstOrFail();
        $note->update([
                          'user_id' => Auth::user()->id ,
                          'body' => $request->body ,
                      ]);

        return response()->json([
                                    'status' => true ,
                                    'message' => 'یادداشت با موفقیت بروز رسانی شد.' ,
                                ]);
    }
}
