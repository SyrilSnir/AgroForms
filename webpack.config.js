const path = require('path');
const webpack = require('webpack');
const publicPath = '../build/';
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const VueLoaderPlugin = require('vue-loader/lib/plugin');
const resolveUrlLoader = {
  loader: 'resolve-url-loader',
  options: {
      sourceMap: true
  }
};

const cssLoader = {
  loader: 'css-loader',
  options: {
      sourceMap: true
  }
};
const sassLoader = {
  loader: 'sass-loader',
  options: {
      sourceMap: true
  }
};


module.exports = {
    entry: {
        main: './assets/scripts/main.js', // основной модуль, содержит подгружаемые библиотеки, в том числе JQuery
        panel: './assets/scripts/panel.js',  // панель управления
        'stand-form': './assets/scripts/stand-form.js',  // панель управления
        'dynamic-form': './assets/scripts/dynamic-form.js',  // панель управления
        manage: './assets/scripts/manage.js'  // модуль управления
    },
    module: {
        rules: [
          {
            test: /\.css$/,
            use: [
              {
                loader: MiniCssExtractPlugin.loader,
                options: {
                    publicPath: publicPath,
                    hwr: false
                },
            },
              cssLoader             
            ],
          },
          {
            test: /\.scss$/,
            use: [
              {
                loader: MiniCssExtractPlugin.loader,
                options: {
                    publicPath: publicPath,
                    hwr: false
                },
            },
              cssLoader,
              resolveUrlLoader,
              sassLoader
            ],
          },
          {
            test: /\.sass$/,
            use: [
              {
                loader: MiniCssExtractPlugin.loader,
                options: {
                    publicPath: publicPath,
                    hwr: false
                },
            },
              cssLoader,
              resolveUrlLoader,
              sassLoader
            ],
          },
          {
            test: /\.vue$/,
            loader: 'vue-loader',
            options: {
              extractCSS: true,
              loaders: {
                 // Since sass-loader (weirdly) has SCSS as its default parse mode, we map
                // the "scss" and "sass" values for the lang attribute to the right configs here.
                // other preprocessors should work out of the box, no loader config like this necessary.
                'scss': [
                  'vue-style-loader',
                  'css-loader',
                  'sass-loader'
                ],
                'sass': [
                  'vue-style-loader',
                  'css-loader',
                  'sass-loader?indentedSyntax'
                ],
                'css': [
                  'vue-style-loader',
                  'css-loader',
                ],
              }
              // other vue-loader options go here
            }
          },          
          {
            test: /\.js$/,
            loader: 'babel-loader',
            exclude: /node_modules/,
          },
          {
            test: /\.(png|jpg|jpeg|gif|ico|svg)$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                          name: 'images/[name].[ext]',
                        },
                    }
                ]
            },
            {
            test: /\.(woff|woff2|eot|ttf|otf)$/,
                use: [
                    {
                        loader:'file-loader',
                        options: {
                          name: 'fonts/[name].[ext]',
                        },
                    }
                ]
            }                     
        ]
    },
    resolve: {
        alias: {
          'vue$': 'vue/dist/vue.esm.js'
        },
        extensions: ['*', '.js', '.vue', '.json']
    },    
    output: {
        path: path.resolve(__dirname,'web','build'),
        filename: 'scripts/[name].js',
    },
    plugins: [     
        new VueLoaderPlugin(),
        new webpack.SourceMapDevToolPlugin({}),
        new webpack.ProvidePlugin({
            jQuery: 'jquery',
            $: 'jquery',
            'window.jQuery': 'jquery',
            Popper: ['popper.js', 'default']
          }),
          new CopyWebpackPlugin([
            { 
                from: './assets/images',
                 to:  'images'
            },
            { 
                from: './assets/fonts',
                 to: 'fonts'
            },
            {
                from: './assets/scripts/vue.js',
                to:  'scripts'
            }
       ]), 
        //  new ExtractTextPlugin("style.css"),
          new MiniCssExtractPlugin({
            filename: './css/[name].css',
            publicPath:'./css/',
         //   chunkFilename: '[id].css',
            ignoreOrder: false, // Enable to remove warnings about conflicting order
         })         
    ],      
    optimization: {
        splitChunks: {
            cacheGroups: {
                commons: {
                    name: 'base',
                    test: 'main',
                    chunks: 'all',
                    minChunks: 2,
                    enforce: true
                },
            }
        },
        // dumps the manifest into a separate file
        runtimeChunk: {
            name: "manifest",
        }
    }

}