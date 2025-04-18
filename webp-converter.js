
import imagemin from 'imagemin';
import imageminWebp from 'imagemin-webp';

const imagesDir = path.resolve(__dirname, 'images');

async function convertToWebP() {
  try {
    // Get list of all image files
    const files = fs.readdirSync(imagesDir);
    const imageFiles = files.filter(file => {
      const ext = path.extname(file).toLowerCase();
      return ['.jpg', '.jpeg', '.png'].includes(ext);
    });

    // Process each file
    for (const file of imageFiles) {
      const filePath = path.join(imagesDir, file);
      const baseName = path.basename(file, path.extname(file));
      const webpPath = path.join(imagesDir, `${baseName}.webp`);
      
      // Skip if WebP already exists
      if (fs.existsSync(webpPath)) {
        console.log(`Skipping ${file} - WebP version already exists`);
        continue;
      }
      
      // Convert to WebP
      await imagemin([filePath], {
        destination: imagesDir+'/build',
        plugins: [
            imageminWebp({
            quality: 75,
            method: 6
          })
        ]
      });
      
      console.log(`Converted ${file} to WebP`);
    }
    
    console.log('WebP conversion completed!');
  } catch (error) {
    console.error('Error converting to WebP:', error);
  }
}

convertToWebP();