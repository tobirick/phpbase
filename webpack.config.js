const path = require('path');
const webpack = require('webpack');
const ExtractTextPlugin = require('extract-text-webpack-plugin');

const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const CSSExtract = new ExtractTextPlugin('../css/main.css');

return (module.exports = {
   entry: './resources/scripts/main.js',
   output: {
      path: path.join(__dirname, 'public', 'js'),
      filename: 'main.js'
   },
   module: {
      rules: [
         {
            loader: 'babel-loader',
            test: /\.js$/,
            exclude: /node_modules/
         },
         {
            test: /\.s?css$/,
            use: CSSExtract.extract({
               use: [
                  {
                     loader: 'css-loader',
                     options: {
                        sourceMap: true
                     }
                  },
                  {
                     loader: 'sass-loader',
                     options: {
                        sourceMap: false
                     }
                  }
               ]
            })
         }
      ]
   },
   plugins: [
    CSSExtract,
    new BrowserSyncPlugin(
        {
            proxy: 'http://phpbase.local:8081/',
            files: [
                {
                    match: [
                        '**/*.php'
                    ],
                    fn: function(event, file) {
                        if (event === "change") {
                            const bs = require('browser-sync').get('bs-webpack-plugin');
                            bs.reload();
                        }
                    }
                }
            ],
            notify: false
        },
        {
            reload: true
        })
   ],
   devServer: {
    proxy: {
        '/': {
            target: {
                host: "phpbase.local",
                protocol: "http:",
                port: 8081
            },
            changeOrigin: true,
            secure: false
        }
    }
    },
   devtool: 'inline-source-map'
});