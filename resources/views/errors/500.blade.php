<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @vite('resources/css/app.css')
  <title>404</title>
  @include('components.favicon')
  <style id="" media="all">
    * {
        -webkit-box-sizing: border-box;
        box-sizing: border-box
    }

    body {
        padding: 0;
        margin: 0;
    }

    #notfound {
        position: relative;
        height: 100vh
    }

    #notfound .notfound {
        position: absolute;
        left: 50%;
        top: 50%;
        -webkit-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%)
    }

    .notfound {
        max-width: 520px;
        width: 100%;
        line-height: 1.4;
        text-align: center
    }

    .notfound .notfound-404 {
        position: relative;
        height: 240px
    }

    .notfound .notfound-404 h1 {
        font-family: 'poppins';
        position: absolute;
        left: 50%;
        top: 50%;
        -webkit-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        font-size: 252px;
        font-weight: 900;
        margin: 0;
        color: var(--primary);
        text-transform: uppercase;
        letter-spacing: -40px;
        margin-left: -20px
    }

    .notfound .notfound-404 h1>span {
        text-shadow: -8px 0 0 #fff
    }

    .notfound .notfound-404 h3 {
        font-family: 'poppins';
        position: relative;
        font-size: 16px;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--primary);
        margin: 0;
        letter-spacing: 3px;
        padding-left: 6px
    }

    .notfound h2 {
        font-family: 'poppins';
        font-size: 20px;
        font-weight: 400;
        text-transform: uppercase;
        color: var(--primary);
        margin-top: 0;
        margin-bottom: 25px
    }

    .home-btn button{
        font-family: 'poppins';
        font-weight: 800;
        width: 50%;
        height: 30px;
        border-radius: 12px;
        border: none;
        background-color: var(--primary);
        color: var(--bg-secondary);
        cursor: pointer;
    }

    .home-btn button:hover{
        background-color: #16437f;
    }

    @media only screen and (max-width: 767px) {
      .notfound .notfound-404 {
        height: 200px
      }

      .notfound .notfound-404 h1 {
        font-size: 200px
      }
    }

    @media only screen and (max-width: 480px) {
      .notfound .notfound-404 {
        height: 162px
      }

      .notfound .notfound-404 h1 {
        font-size: 162px;
        height: 150px;
        line-height: 162px
      }

      .notfound h2 {
        font-size: 16px
      }
    }
  </style>
  <meta name="robots" content="noindex, follow">
</head>

<body>
    <div id="notfound">
        <div class="notfound">
        <div class="notfound-404">
            <h3>Oops! Internal Server Error</h3>
            <h1><span>5</span><span>0</span><span>0</span></h1>
        </div>
        <h2>Something is Wrong</h2>
        <div class="home-btn">
            <form action="/sesi">
                <button>Home</button>
            </form>
        </div>
        </div>
    </div>
</body>

</html>