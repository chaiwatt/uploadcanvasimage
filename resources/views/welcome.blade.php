<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

        #canvas{
            border:1px solid red;
        }
        </style>


    </head>
    <body>
        <div class="flex-center  ">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

                    <button id ="btnupload" class="btn btn-lg btn-primary">upload</button>
               
        
        </div>

    <div id="container">
      <div style="max-height: 600px;max-width:600px;overflow: scroll;">
        <canvas id="canvas"></canvas>
      </div>  
    </div>
       


    </body>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script>
        $("#btnupload").click(function(){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var canvas = document.getElementById('canvas');
            var dataURL = canvas.toDataURL();

            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

            $.ajax({
    			type:"post",
    			url:"{{ route('upload') }}",
                    data: {
                        img: dataURL,
                    },
    			success:function(response){
    				console.log(response);
    			}
    		})
        })

    $(function() {
      var canvas = document.getElementById("canvas");
      var ctx = canvas.getContext("2d");
      var imageOpacity = 1;
      var canvasPos = canvas.getBoundingClientRect();
      var dragging = false;
      var img = new Image();
      img.onload = start;
      img.setAttribute('crossOrigin', 'anonymous');
      img.src = "{{ asset('storage/uploads/treatment/heart.png') }}";
    
      function start() {
        canvas.width = canvas.width = img.width;
        canvas.height = img.height;
        ctx.strokeStyle = "green";
        ctx.lineWidth = 3;
    
        $("#canvas").mousedown(function(e) {
          handleMouseDown(e);
        });
        $("#canvas").mousemove(function(e) {
          handleMouseMove(e);
        });
        $("#canvas").mouseup(function(e) {
          handleMouseUp(e);
        });
        $("#canvas").mouseout(function(e) {
          handleMouseUp(e);
        });
    
        // redraw the image
        drawTheImage(img, imageOpacity);
      }
    
      function drawTheImage(img, opacity) {
        ctx.globalAlpha = opacity;
        ctx.drawImage(img, 0, 0);
        ctx.globalAlpha = 1.0;
      }
    
      function handleMouseDown(e) {
        var pos = getCursorPosition(e);
        dragging = true;
        ctx.strokeStyle = "green";
        ctx.lineCap = "round";
        ctx.lineJoin = "round";
        ctx.lineWidth = 3;
        ctx.beginPath();
        ctx.moveTo(pos.x, pos.y);
      }
    
      function handleMouseUp(e) {
        dragging = false;
      }
    
      function handleMouseMove(e) {
        var pos, i;
        if (!dragging) {
          return;
        }
        pos = getCursorPosition(e);
        ctx.lineTo(pos.x, pos.y);
        ctx.stroke();
      }
    
      function getCursorPosition(evt) {
        var ClientRect = canvas.getBoundingClientRect();
            return {
            x: Math.round(evt.clientX - ClientRect.left),
            y: Math.round(evt.clientY - ClientRect.top)
        }
      }
    }); 
    </script>
</html>
