var Module=typeof pyodide._module!=="undefined"?pyodide._module:{};Module.checkABI(1);if(!Module.expectedDataFileDownloads){Module.expectedDataFileDownloads=0;Module.finishedDataFileDownloads=0}Module.expectedDataFileDownloads++;(function(){var loadPackage=function(metadata){var PACKAGE_PATH;if(typeof window==="object"){PACKAGE_PATH=window["encodeURIComponent"](window.location.pathname.toString().substring(0,window.location.pathname.toString().lastIndexOf("/"))+"/")}else if(typeof location!=="undefined"){PACKAGE_PATH=encodeURIComponent(location.pathname.toString().substring(0,location.pathname.toString().lastIndexOf("/"))+"/")}else{throw"using preloaded data can only be done on a web page or in a web worker"}var PACKAGE_NAME="autograd.data";var REMOTE_PACKAGE_BASE="autograd.data";if(typeof Module["locateFilePackage"]==="function"&&!Module["locateFile"]){Module["locateFile"]=Module["locateFilePackage"];err("warning: you defined Module.locateFilePackage, that has been renamed to Module.locateFile (using your locateFilePackage for now)")}var REMOTE_PACKAGE_NAME=Module["locateFile"]?Module["locateFile"](REMOTE_PACKAGE_BASE,""):REMOTE_PACKAGE_BASE;var REMOTE_PACKAGE_SIZE=metadata.remote_package_size;var PACKAGE_UUID=metadata.package_uuid;function fetchRemotePackage(packageName,packageSize,callback,errback){var xhr=new XMLHttpRequest;xhr.open("GET",packageName,true);xhr.responseType="arraybuffer";xhr.onprogress=function(event){var url=packageName;var size=packageSize;if(event.total)size=event.total;if(event.loaded){if(!xhr.addedTotal){xhr.addedTotal=true;if(!Module.dataFileDownloads)Module.dataFileDownloads={};Module.dataFileDownloads[url]={loaded:event.loaded,total:size}}else{Module.dataFileDownloads[url].loaded=event.loaded}var total=0;var loaded=0;var num=0;for(var download in Module.dataFileDownloads){var data=Module.dataFileDownloads[download];total+=data.total;loaded+=data.loaded;num++}total=Math.ceil(total*Module.expectedDataFileDownloads/num);if(Module["setStatus"])Module["setStatus"]("Downloading data... ("+loaded+"/"+total+")")}else if(!Module.dataFileDownloads){if(Module["setStatus"])Module["setStatus"]("Downloading data...")}};xhr.onerror=function(event){throw new Error("NetworkError for: "+packageName)};xhr.onload=function(event){if(xhr.status==200||xhr.status==304||xhr.status==206||xhr.status==0&&xhr.response){var packageData=xhr.response;callback(packageData)}else{throw new Error(xhr.statusText+" : "+xhr.responseURL)}};xhr.send(null)}function handleError(error){console.error("package error:",error)}var fetchedCallback=null;var fetched=Module["getPreloadedPackage"]?Module["getPreloadedPackage"](REMOTE_PACKAGE_NAME,REMOTE_PACKAGE_SIZE):null;if(!fetched)fetchRemotePackage(REMOTE_PACKAGE_NAME,REMOTE_PACKAGE_SIZE,function(data){if(fetchedCallback){fetchedCallback(data);fetchedCallback=null}else{fetched=data}},handleError);function runWithFS(){function assert(check,msg){if(!check)throw msg+(new Error).stack}Module["FS_createPath"]("/","lib",true,true);Module["FS_createPath"]("/lib","python3.7",true,true);Module["FS_createPath"]("/lib/python3.7","site-packages",true,true);Module["FS_createPath"]("/lib/python3.7/site-packages","autograd-1.3-py3.7.egg-info",true,true);Module["FS_createPath"]("/lib/python3.7/site-packages","autograd",true,true);Module["FS_createPath"]("/lib/python3.7/site-packages/autograd","misc",true,true);Module["FS_createPath"]("/lib/python3.7/site-packages/autograd","numpy",true,true);Module["FS_createPath"]("/lib/python3.7/site-packages/autograd","scipy",true,true);Module["FS_createPath"]("/lib/python3.7/site-packages/autograd/scipy","stats",true,true);function DataRequest(start,end,audio){this.start=start;this.end=end;this.audio=audio}DataRequest.prototype={requests:{},open:function(mode,name){this.name=name;this.requests[name]=this;Module["addRunDependency"]("fp "+this.name)},send:function(){},onload:function(){var byteArray=this.byteArray.subarray(this.start,this.end);this.finish(byteArray)},finish:function(byteArray){var that=this;Module["FS_createPreloadedFile"](this.name,null,byteArray,true,true,function(){Module["removeRunDependency"]("fp "+that.name)},function(){if(that.audio){Module["removeRunDependency"]("fp "+that.name)}else{err("Preloading file "+that.name+" failed")}},false,true);this.requests[this.name]=null}};function processPackageData(arrayBuffer){Module.finishedDataFileDownloads++;assert(arrayBuffer,"Loading data file failed.");assert(arrayBuffer instanceof ArrayBuffer,"bad input to processPackageData");var byteArray=new Uint8Array(arrayBuffer);var curr;var compressedData={data:null,cachedOffset:74541,cachedIndexes:[-1,-1],cachedChunks:[null,null],offsets:[0,1210,2410,3600,4970,6260,7519,8516,9466,10476,11722,12895,14183,15335,16643,17671,18768,19756,20778,21773,23084,24257,25599,26854,27574,28291,28995,29867,30944,32112,33422,34189,35309,36372,37298,38256,39399,40498,41556,42842,43429,44275,45176,46047,47332,48021,49334,50595,51970,53373,54454,55842,56455,57401,58363,59444,60830,61956,63285,64657,65755,66910,67894,68826,69909,70623,71455,71981,72836,73643],sizes:[1210,1200,1190,1370,1290,1259,997,950,1010,1246,1173,1288,1152,1308,1028,1097,988,1022,995,1311,1173,1342,1255,720,717,704,872,1077,1168,1310,767,1120,1063,926,958,1143,1099,1058,1286,587,846,901,871,1285,689,1313,1261,1375,1403,1081,1388,613,946,962,1081,1386,1126,1329,1372,1098,1155,984,932,1083,714,832,526,855,807,898],successes:[1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1]};compressedData.data=byteArray;assert(typeof Module.LZ4==="object","LZ4 not present - was your app build with  -s LZ4=1  ?");Module.LZ4.loadPackage({metadata:metadata,compressedData:compressedData});Module["removeRunDependency"]("datafile_autograd.data")}Module["addRunDependency"]("datafile_autograd.data");if(!Module.preloadResults)Module.preloadResults={};Module.preloadResults[PACKAGE_NAME]={fromCache:false};if(fetched){processPackageData(fetched);fetched=null}else{fetchedCallback=processPackageData}}if(Module["calledRun"]){runWithFS()}else{if(!Module["preRun"])Module["preRun"]=[];Module["preRun"].push(runWithFS)}};loadPackage({files:[{filename:"/lib/python3.7/site-packages/autograd-1.3-py3.7.egg-info/PKG-INFO",start:0,end:679,audio:0},{filename:"/lib/python3.7/site-packages/autograd-1.3-py3.7.egg-info/top_level.txt",start:679,end:688,audio:0},{filename:"/lib/python3.7/site-packages/autograd-1.3-py3.7.egg-info/requires.txt",start:688,end:715,audio:0},{filename:"/lib/python3.7/site-packages/autograd-1.3-py3.7.egg-info/dependency_links.txt",start:715,end:716,audio:0},{filename:"/lib/python3.7/site-packages/autograd-1.3-py3.7.egg-info/SOURCES.txt",start:716,end:1933,audio:0},{filename:"/lib/python3.7/site-packages/autograd/differential_operators.py",start:1933,end:10325,audio:0},{filename:"/lib/python3.7/site-packages/autograd/util.py",start:10325,end:11807,audio:0},{filename:"/lib/python3.7/site-packages/autograd/extend.py",start:11807,end:12111,audio:0},{filename:"/lib/python3.7/site-packages/autograd/builtins.py",start:12111,end:18221,audio:0},{filename:"/lib/python3.7/site-packages/autograd/wrap_util.py",start:18221,end:19802,audio:0},{filename:"/lib/python3.7/site-packages/autograd/__init__.py",start:19802,end:20306,audio:0},{filename:"/lib/python3.7/site-packages/autograd/tracer.py",start:20306,end:24257,audio:0},{filename:"/lib/python3.7/site-packages/autograd/test_util.py",start:24257,end:27138,audio:0},{filename:"/lib/python3.7/site-packages/autograd/core.py",start:27138,end:39373,audio:0},{filename:"/lib/python3.7/site-packages/autograd/misc/flatten.py",start:39373,end:40493,audio:0},{filename:"/lib/python3.7/site-packages/autograd/misc/optimizers.py",start:40493,end:43250,audio:0},{filename:"/lib/python3.7/site-packages/autograd/misc/fixed_points.py",start:43250,end:44021,audio:0},{filename:"/lib/python3.7/site-packages/autograd/misc/tracers.py",start:44021,end:46221,audio:0},{filename:"/lib/python3.7/site-packages/autograd/misc/__init__.py",start:46221,end:46283,audio:0},{filename:"/lib/python3.7/site-packages/autograd/numpy/random.py",start:46283,end:46432,audio:0},{filename:"/lib/python3.7/site-packages/autograd/numpy/numpy_vjps.py",start:46432,end:79001,audio:0},{filename:"/lib/python3.7/site-packages/autograd/numpy/numpy_jvps.py",start:79001,end:89770,audio:0},{filename:"/lib/python3.7/site-packages/autograd/numpy/numpy_boxes.py",start:89770,end:92894,audio:0},{filename:"/lib/python3.7/site-packages/autograd/numpy/numpy_wrapper.py",start:92894,end:98362,audio:0},{filename:"/lib/python3.7/site-packages/autograd/numpy/linalg.py",start:98362,end:106285,audio:0},{filename:"/lib/python3.7/site-packages/autograd/numpy/__init__.py",start:106285,end:106517,audio:0},{filename:"/lib/python3.7/site-packages/autograd/numpy/numpy_vspaces.py",start:106517,end:108521,audio:0},{filename:"/lib/python3.7/site-packages/autograd/numpy/fft.py",start:108521,end:113771,audio:0},{filename:"/lib/python3.7/site-packages/autograd/scipy/misc.py",start:113771,end:113939,audio:0},{filename:"/lib/python3.7/site-packages/autograd/scipy/linalg.py",start:113939,end:116302,audio:0},{filename:"/lib/python3.7/site-packages/autograd/scipy/__init__.py",start:116302,end:116485,audio:0},{filename:"/lib/python3.7/site-packages/autograd/scipy/integrate.py",start:116485,end:119352,audio:0},{filename:"/lib/python3.7/site-packages/autograd/scipy/signal.py",start:119352,end:125276,audio:0},{filename:"/lib/python3.7/site-packages/autograd/scipy/special.py",start:125276,end:130411,audio:0},{filename:"/lib/python3.7/site-packages/autograd/scipy/stats/beta.py",start:130411,end:131743,audio:0},{filename:"/lib/python3.7/site-packages/autograd/scipy/stats/chi2.py",start:131743,end:132552,audio:0},{filename:"/lib/python3.7/site-packages/autograd/scipy/stats/gamma.py",start:132552,end:133539,audio:0},{filename:"/lib/python3.7/site-packages/autograd/scipy/stats/dirichlet.py",start:133539,end:134311,audio:0},{filename:"/lib/python3.7/site-packages/autograd/scipy/stats/poisson.py",start:134311,end:135026,audio:0},{filename:"/lib/python3.7/site-packages/autograd/scipy/stats/norm.py",start:135026,end:137784,audio:0},{filename:"/lib/python3.7/site-packages/autograd/scipy/stats/t.py",start:137784,end:140454,audio:0},{filename:"/lib/python3.7/site-packages/autograd/scipy/stats/__init__.py",start:140454,end:140845,audio:0},{filename:"/lib/python3.7/site-packages/autograd/scipy/stats/multivariate_normal.py",start:140845,end:143354,audio:0}],remote_package_size:78637,package_uuid:"eaf78dff-e5e5-46e7-9677-16fdada593f4"})})();