<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SpotifyWire</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  </head>
  <body class="text-center">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
      <a class="navbar-brand" href="#">SpotifyWire</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </nav>
    <main role="main" class="container" style="padding: 5%;">
      <div class="starter-template">
        <h1>Bem vindo ao SpotifyWire</h1>
        <h3 class="mb-3 font-weight-normal">Ache qualquer música no Spotify!</h3>
        <div class="input-group mb-3">
          <input id="busca" name="busca" type="text" class="form-control" placeholder="Pesquise" aria-label="Pesquise" required>
          <div class="input-group-append">
            <button id="search" class="btn btn-outline-secondary" type="button">Buscar</button>
          </div>
        </div>
        <div id="searchList" class="row"></div>
      </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script type="text/javascript">
      if (window.navigator.onLine == false){        
        document.getElementById("busca").disabled=true;
        document.getElementById("search").disabled=true;
        document.getElementById("searchList").innerHTML = '<div class="alert alert-warning" role="alert"> Verifique a sua conexão com a internet!</div>';
      }
      $(document).keypress(function(e) {
          if(e.which == 13){
            document.getElementById("search").click();
          }
      });
      document.getElementById("search").addEventListener("click", function(){
        var busca = document.getElementById("busca").value;
        var htmlinner = '<div class="col-6 themed-grid-col"><h5>Música</h5></div><div class="col-6 themed-grid-col"><h5>Artista</h5></div>';
        var div = document.getElementById("searchList");
        var xmlhttp = new XMLHttpRequest();
        if (busca == ''){
          div.innerHTML = '<div class="alert alert-danger" role="alert"> Digite o nome da música que deseja buscar!</div>';
        } else {
          xmlhttp.onreadystatechange = function() {
            document.getElementById("busca").disabled=true;
            document.getElementById("search").disabled=true;
            div.innerHTML ='<button class="btn btn-success my-2 my-sm-0" disabled><span class="spinner-border spinner-border-sm"></span> Loading... </button>';
            if (this.readyState == 4 && this.responseText && this.status == 200) {
              var i, j;
              var res = this.responseText;
              const obj = JSON.parse(res);
              if (obj.tracks){
                resp = obj.tracks.items;
                var len = resp.length
                for (i = 0; i < len; i++){
                  artista = resp[i].artists;
                  htmlinner += '<div class="col-6 themed-grid-col"><a href="'+resp[i].external_urls.spotify+'" target="_blank"><h6 class="text-left">'+resp[i].name+'</h6></a></div>';
                  htmlinner += '<div class="col-6 themed-grid-col"><h6 class="text-left">';
                  for (j = 0; j < artista.length; j++){
                    htmlinner += artista[j].name+' ';
                  }
                  htmlinner += '</h6></div>';

                }
                res = htmlinner;
              } else {
                res = '<h6 class="text-center">'+obj.error.message+'</h6>';
              }
              div.innerHTML = res;
            }
            document.getElementById("busca").disabled=false;
            document.getElementById("search").disabled=false;
          }
          xmlhttp.open("GET","search?busca="+busca,true);
          xmlhttp.send();
        }
      });
    </script>
  </body>
</html>