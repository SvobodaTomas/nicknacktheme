const path = require('path');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const WebpackAssetsManifest = require('webpack-assets-manifest');
const ImageminPlugin = require('imagemin-webpack-plugin').default;
const ImageminWebp = require('imagemin-webp');
const fs = require('fs');

// Define paths
const themePath = path.resolve(__dirname);
const srcPath = path.resolve(themePath, 'src');
const distPath = path.resolve(themePath, 'dist');
const imgSrcPath = path.resolve(srcPath, 'images');
const imgDistPath = path.resolve(themePath, 'images');

// Ensure directories exist
if (!fs.existsSync(distPath)) {
  fs.mkdirSync(distPath, { recursive: true });
}
if (!fs.existsSync(imgDistPath)) {
  fs.mkdirSync(imgDistPath, { recursive: true });
}

module.exports = {
  entry: {
    main: path.resolve(srcPath, 'js/main.js'),
    // Add additional entry points if needed
    form: path.resolve(srcPath, 'js/form.js'),
  },
  output: {
    path: distPath,
    filename: 'js/[name].min.js',
    publicPath: '/wp-content/themes/nicknack/dist/'
  },
  module: {
    rules: [
      // JavaScript
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: ['@babel/preset-env']
          }
        }
      },
      // CSS
      {
        test: /\.css$/,
        use: [
          MiniCssExtractPlugin.loader,
          'css-loader',
          {
            loader: 'postcss-loader',
            options: {
              postcssOptions: {
                plugins: [
                  ['cssnano', {}]
                ]
              }
            }
          }
        ]
      },
      // SCSS/SASS
      {
        test: /\.(scss|sass)$/,
        use: [
          MiniCssExtractPlugin.loader,
          'css-loader',
          {
            loader: 'postcss-loader',
            options: {
              postcssOptions: {
                plugins: [
                  ['cssnano', {}]
                ]
              }
            }
          },
          'sass-loader'
        ]
      },
      // Images
      {
        test: /\.(png|jpe?g|gif|svg)$/i,
        use: [
          {
            loader: 'file-loader',
            options: {
              name: 'images/[name].[ext]',
              outputPath: '../', // Output relative to dist folder
              publicPath: '../'
            }
          }
        ]
      }
    ]
  },
  plugins: [
    new CleanWebpackPlugin({
      cleanOnceBeforeBuildPatterns: [
        '**/*',
        '!images/**', // Preserve images directory
      ],
    }),
    new MiniCssExtractPlugin({
      filename: 'css/[name].min.css'
    }),
    new WebpackAssetsManifest({
      output: 'assets-manifest.json',
      integrity: true,
      entrypoints: true
    }),
    new ImageminPlugin({
      test: /\.(jpe?g|png|gif|svg)$/i,
      pngquant: {
        quality: '65-90'
      },
      plugins: [
        ImageminWebp({
          quality: 75,
          method: 6,
          resize: { width: 0, height: 0 }
        })
      ],
      // Only create WebP versions if they don't already exist
      externalImages: {
        context: imgSrcPath,
        destination: imgDistPath,
        fileName: ({ file }) => {
          // Check if WebP version already exists
          const baseName = path.basename(file, path.extname(file));
          const webpPath = path.resolve(imgDistPath, `${baseName}.webp`);
          
          // If WebP version doesn't exist, create it
          if (!fs.existsSync(webpPath)) {
            return `${baseName}.webp`;
          }
          
          // Return null to skip this file
          return null;
        }
      }
    })
  ],
  optimization: {
    splitChunks: {
      cacheGroups: {
        commons: {
          test: /[\\/]node_modules[\\/]/,
          name: 'vendors',
          chunks: 'all'
        }
      }
    }
  }
};