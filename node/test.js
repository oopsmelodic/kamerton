//var exec = require('child_process').exec;
//var cmd = 'ls -al';

//exec(cmd, function(error, stdout, stderr) {
//  console.log(stdout);
//});

 var fs = require('fs');
 var http = require('http');
 var options = {
    host: '10.153.0.22',
    port: 15000,
    path: '/action=AddTask&ResponseFormat=json&Lang=RURU-tel&Type=WorkBitch&Out=123.mp4',
    method: 'POST'
};
var file_path = '/var/www/main/files/import/video_34ce9e3c6dd9a6581789a74cffec5c91.webm';
var stats = fs.statSync(file_path);



fs.readFile(file_path, 'utf8', function (err,data) {
  if (err) {
    return console.log(err); 
 }
     var buff = new Buffer(data);
     console.log('Buff Size: '+buff.length);
     var str = 'taskdata='+buff.toString('base64');
     options.headers =  {
        'Content-Type': 'application/x-www-form-urlencoded',
        'Content-Length': str.length                
    };
    var req = http.request(options, function(res) {
      console.log('STATUS: ' + res.statusCode);
      console.log('HEADERS: ' + JSON.stringify(res.headers));
      res.setEncoding('utf8');  
      res.on('data', function (chunk) {
        console.log('BODY: ' + chunk);
      });
    });

    req.on('error', function(e) {
      console.log('problem with request: ' + e.message);
    }); 
    req.write(str);  
    req.end();   
}); 

// write data to request body
