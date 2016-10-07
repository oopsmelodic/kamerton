var http = require('http');
//var express = require("express");
//var app = express();
var amqp = require('amqplib');
var when = require('when');
var fs = require('fs');
var querystring = require('querystring');

var total_req = 0;
var resp_req = 0;
var speechServer = {
    host: '10.153.0.22',
    port: 15000,
    path: '',
    method: 'POST',
    headers : null
};   

//Worker Core pass on RabbitMQ

amqp.connect('amqp://localhost:5672').then(function(conn) {
  process.once('SIGINT', function() { conn.close(); });
  console.log('[*] Init RabbitMQ Session');
  return conn.createChannel().then(function(ch) {
  console.log('[*] Create Chanel');   
    var ok = ch.assertQueue('to_work', {durable: false, autoDelete:true,passive:true});

    ok = ok.then(function(_qok) {
      return ch.consume('to_work', function(msg) {
//        console.log(msg);
        var results = JSON.parse(msg.content.toString());
        
        console.log(" [x] Received Message");
        console.log(" Message: '%s'", results.msg);
        console.log(" Host: '%s'", results.from);
        console.log(" UserAgent: '%s'", results.user_agent);
        console.log(" [x] End Message");
        total_req++;         
//        speechServer.headers =  {
//            'Content-Type': 'application/x-www-form-urlencoded',
//            'Content-Length': tt.length                
//        };
        
        speechServer.path = makeReq(results);
        
        var req = http.request(speechServer, function(res) {
          console.log('STATUS: ' + res.statusCode);
          console.log('HEADERS: ' + JSON.stringify(res.headers));
          res.setEncoding('utf8');
          res.on('data', function (chunk) {
            resp_req++;
            //JSON CHUNK FROM MESSAGE
            console.log('TOTAL_REQ: ' + total_req);
            console.log('RESP_REQ: ' + resp_req);
            var resjson = JSON.parse(chunk);        
            console.log(resjson);
            if (resjson.autnresponse.response.$=='SUCCESS'){                        
//                    var action =resjson.autnresponse.action.$ || null;
                    var token = resjson.autnresponse.responsedata.token.$ || null;
            }

          });
        });
        req.on('error', function(e) {
          console.log('problem with request: ' + e.message);
        });       
        
//        console.log(tt);
//        req.write(tt.toString());
        req.end();          
        
        var date = new Date();
        ch.sendToQueue('from_worker', new Buffer('Recive message from host: "'+results.msg+'" DateTime: '+date.toString()));        
      }, {noAck: true});
    });

    return ok.then(function(_consumeOk) {
      console.log(' [*] Waiting for messages. To exit press CTRL+C');
    });
  });
}).then(null, console.warn);    




//function getResults(){
//    var action = 'GetResults';
//    var action_type= null;
//    var action_lang = '';
//    speechServer.path = makeReq('GetResults','123dfasdf2314');
//    
//}


//function toSpeech(results){
////        speechServer.headers =  {
////            'Content-Type': 'application/x-www-form-urlencoded',
////            'Content-Length': tt.length                
////        };
//        speechServer.path = '/action=AddTask&ResponseFormat=json'+
//            '&Type='+action_type+
//            '&Lang='+action_lang+
//            '&Out=1235.wav';                
//        
//        var req = http.request(speechServer, function(res) {
//          console.log('STATUS: ' + res.statusCode);
//          console.log('HEADERS: ' + JSON.stringify(res.headers));
//          res.setEncoding('utf8');
//          res.on('data', function (chunk) {
//            resp_req++;
//            //JSON CHUNK FROM MESSAGE
//            console.log('TOTAL_REQ: ' + total_req);
//            console.log('RESP_REQ: ' + resp_req);
//            var resjson = JSON.parse(chunk);        
//            console.log(resjson);
//            if (resjson.autnresponse.response.$=='SUCCESS'){                        
////                    var action =resjson.autnresponse.action.$ || null;
//                    var token = resjson.autnresponse.responsedata.token.$ || null;
//            }
//
//          });
//        });
//        req.on('error', function(e) {
//          console.log('problem with request: ' + e.message);
//        });       
//        
////        console.log(tt);
////        req.write(tt.toString());
//        req.end();       
//}


function makeReq(results){
        //Parse Results
        switch (results.type.toLowerCase()){
            case 'to_idol':
                var req_path = '/';
                for (var i =0 ; i<=results.taskdata.length;i++){
                    
                }
            break
        }                      
}


//HTTP Status

//http.createServer(function (request, response) {
//    response.writeHead(200, {'Content-Type': 'text/plain'});
//    response.end('Worker test Status\n');
//}).listen(8124);
//console.log('Worker WebStatus running at http://10.129.15.111:8124/');