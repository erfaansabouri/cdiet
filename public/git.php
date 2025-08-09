<?php

$repositoryPath = '/home/caloried/caloriediet-back'; // Replace with the path to your local repository
$folderToCopy = 'public'; // Replace with the path of the folder you want to copy
$destinationFolder = '/home/caloried/public_html'; // Replace with the destination path
chdir($repositoryPath);
$sourcePath = $repositoryPath.'/'.$folderToCopy;
$destinationPath = $destinationFolder;
if (copyFolderContents($sourcePath, $destinationPath)) {
    echo 'Folder contents copied successfully.';
    customizeIndexPhp();

} else {
    echo 'Folder contents copy failed.';
}
// Function to recursively copy the contents of a folder
function copyFolderContents($src, $dst)
{
    if (is_dir($src)) {
        if (! is_dir($dst)) {
            mkdir($dst);
        }
        $files = scandir($src);
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                copyFolderContents("$src/$file", "$dst/$file");
            }
        }
    } elseif (file_exists($src)) {
        copy($src, $dst);
    }

    return true;
}

function customizeIndexPhp()
{
    $filePath = '/home/caloried/public_html/index.php'; // Replace with the actual path to your index.php file
    // Read the current content of the file
    $currentContent = file_get_contents($filePath);
    // Replace the old path with the new path
    $modifiedContent = str_replace('/../storage/framework/maintenance.php', '/../caloriediet-back/storage/framework/maintenance.php', $currentContent);
    $modifiedContent = str_replace('/../vendor/autoload.php', '/../caloriediet-back/vendor/autoload.php', $modifiedContent);
    $modifiedContent = str_replace('/../bootstrap/app.php', '/../caloriediet-back/bootstrap/app.php', $modifiedContent);
    $modifiedContent = str_replace("bootstrap/app.php';", "bootstrap/app.php';"."\n".'$app->bind("path.public", function(){return __DIR__;});', $modifiedContent);
    // Write the modified content back to the file
    if (file_put_contents($filePath, $modifiedContent)) {
        echo 'Content updated successfully.';
    } else {
        echo 'Content update failed.';
    }
}
