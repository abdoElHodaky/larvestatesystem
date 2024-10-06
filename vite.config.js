import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { VitePWA } from 'vite-plugin-pwa'
import { ViteImageOptimizer } from 'vite-plugin-image-optimizer';
export default defineConfig({
    plugins: [
       ViteImageOptimizer({
  test: /\.(jpe?g|png|gif|tiff|webp|svg|avif)$/i,
 // exclude: undefined,
 // include: undefined,
  includePublic: true,
  logStats: true,
  ansiColors: true,
  svg: {
    multipass: true,
    plugins: [
      {
        name: 'preset-default',
        params: {
          overrides: {
            cleanupNumericValues: false,
            removeViewBox: false, // https://github.com/svg/svgo/issues/1128
          },
          cleanupIDs: {
            minify: false,
            remove: false,
          },
          convertPathData: false,
        },
      },
      'sortAttrs',
      {
        name: 'addAttributesToSVGElement',
        params: {
          attributes: [{ xmlns: 'http://www.w3.org/2000/svg' }],
        },
      },
    ],
  },
  png: {
    // https://sharp.pixelplumbing.com/api-output#png
    quality: 100,
  },
  jpeg: {
    // https://sharp.pixelplumbing.com/api-output#jpeg
    quality: 100,
  },
  jpg: {
    // https://sharp.pixelplumbing.com/api-output#jpeg
    quality: 100,
  },
  tiff: {
    // https://sharp.pixelplumbing.com/api-output#tiff
    quality: 100,
  },
  // gif does not support lossless compression
  // https://sharp.pixelplumbing.com/api-output#gif
  gif: {},
  webp: {
    // https://sharp.pixelplumbing.com/api-output#webp
    lossless: true,
  },
  avif: {
    // https://sharp.pixelplumbing.com/api-output#avif
    lossless: true,
  },
  cache: true,
  cacheLocation: "public/assets_caches"
        })
        ,VitePWA({
           registerType:"auto",
            workbox: {
    maximumFileSizeToCacheInBytes:10*1024*1024*1024,
	globDirectory: 'public/',
	globPatterns: [
		'**/.{css,png,jpg,ico,js,txt}'
	],
	//navigateFallback:"/offline",
	runtimeCaching: [{
    urlPattern: ({request, url}) =>url.includes("cdn")==true,
    handler: 'NetworkFirst',
    options: {
      cacheName: 'cdns',
      expiration: {
        maxEntries: 20,
	maxAgeSeconds: 2 * 24 * 60 * 60,
      },
      cacheableResponse:{
	statuses: [0, 200]
      }
    },
  },{
    urlPattern: ({request, url}) => request.method=="POST",
    handler:"NetworkOnly",
    method:"POST",
    options:{
      cacheName:"apCachePost",
      cacheableResponse:{
	statuses: [0, 200]
      },
      backgroundSync:{
       name:"Apisync",
       options:{
    	maxRetentionTime:24*60*2
       }
      }
    }
  },{
    urlPattern: ({request, url}) =>url.includes("fonts")==true,
    handler: 'NetworkFirst',
    options: {
      cacheName: 'cdns',
      expiration: {
        maxEntries: 20,
	maxAgeSeconds: 2 * 24 * 60 * 60,
      },
      cacheableResponse:{
	statuses: [0, 200]
      }
    }
  }],
   swDest: 'public/sw.js'
}}),
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/swreg.js'
            ],
            refresh: true,
        }),
    ],
});
