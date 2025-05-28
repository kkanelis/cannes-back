<?php

namespace Database\Seeders;

use App\Models\Movie;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class MovieSeeder extends Seeder
{
    public function run()
    {
        // Create storage directory if it doesn't exist
        if (!File::exists(storage_path('images'))) {
            File::makeDirectory(storage_path('images'), 0777, true);
        }

        // Use json directory directly
        $jsonPath = storage_path('json');
        $jsonFiles = File::files($jsonPath);

        foreach ($jsonFiles as $file) {
            if ($file->getExtension() === 'json') {
                $content = File::get($file->getPathname());
                $movieData = json_decode($content, true);
                
                if (isset($movieData['poster_url'])) {
                    $imageName = $movieData['poster_url'];
                    $sourcePath = storage_path('json/' . $imageName);
                    
                    if (File::exists($sourcePath)) {
                        File::copy(
                            $sourcePath,
                            storage_path('images/' . $imageName)
                        );
                        
                        $movieData['poster_url'] = 'images/' . $imageName;
                    }
                }
                
                Movie::create($movieData);
            }
        }
    }
}