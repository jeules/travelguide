<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Travel Guide</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
</head>

<style>

  body{
    height: 100vh;
    font-weight: 300;
  }

  .swal-overlay {
    background-color: rgba(43, 165, 137, 0.45);
  }

  #introMsg{
    font-size: 70px;
  }

  #sakura {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    pointer-events: none;
    z-index: 1000;
  }

  @media (min-width: 768px) {
  .modal-xl {
    width: 90%;
   max-width:1200px;
  }
}

</style>

<body>
  <div id="sakura"></div>
  <div class="container-fluid bg-light h-100">
    <div class="row h-100">
      <div class="col-12 m-auto text-center">
        <div id="introMsg">
        </div>
        
        <div id="searchBar" class="d-none">
          <div class="row no-gutters mt-3 justify-content-center">
            <div class="col-6">
              <input class="form-control border-secondary rounded-pill pr-5" type="search" placeholder="Enter your destination" id="example-search-input2" required/>

              <div class="row mt-2 ml-2">
                <div class="btn-group">
                  <a href="#" class="btn btn-outline-light text-dark disabled">Popular: </a>
                  <a href="#" class="btn btn-outline-light text-dark disabled">Tokyo</a>
                  <a href="#" class="btn btn-outline-light text-dark disabled">Yokohama</a>
                  <a href="#" class="btn btn-outline-light text-dark disabled">Kyoto</a>
                  <a href="#" class="btn btn-outline-light text-dark disabled">Osaka</a>
                  <a href="#" class="btn btn-outline-light text-dark disabled">Sapporo</a>
                  <a href="#" class="btn btn-outline-light text-dark disabled">Nogoya</a>
                </div>
              </div>
            </div>
            <div class="col-auto">
              <!-- <button class="btn btn-outline-light text-dark border-0 rounded-pill ml-n5" type="button" data-toggle="modal" data-target="#exampleModal">
                <i class="fa fa-search"></i>
              </button> -->
              <button class="btn btn-outline-light text-dark border-0 rounded-pill ml-n5" type="sumbit" id="submitSearch">
                <i class="fa fa-search"></i>
              </button>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>


  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitle">Search Results</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container dataTables_scroll">
            <table class="table table-striped table-hover" id="resultTable">
              <thead>
                <tr>
                  <th width="20%">Venue</th>
                  <th width="40%">Address</th>
                  <th width="20%">City</th>
                  <th width="20%">Weather</th>
                </tr>
              </thead>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</html>

<script>
  $(function (){
    let msg = ['Welcome', 'ようこそ'];

    msg.forEach(function(value, index){
      $('<div />', {
        text : value,
        css  : {display: 'none'}
      }).delay(index * 3000).fadeIn('slow').appendTo('#introMsg').fadeOut(2000);
    });

    setTimeout(() => {
      $('#introMsg').html('Travel Guide');
    }, 5000);

    setTimeout(() => {
      $('#searchBar').removeClass('d-none').fadeIn();
    }, 6000);

    function processInputData(queryVenue){
      
      //if(queryVenue != null && queryVenue != '' && queryVenue != 'undefined'){
      if(queryVenue != ''){

        var table = $('#resultTable').DataTable( {
          scrollY: '50vh',
          destroy: true,
          ajax:{
            url: '/main/' + queryVenue,
            //dataSrc: 'response.venues'
            dataSrc: 'data'
          },
          columnDefs:[
            {targets: [0], width: '20%', data: 'name', defaultContent: ''},
            {targets: [1], width: '40%', data: 'location.address', defaultContent: ''},
            {targets: [2], width: '20%', data: 'location.city', defaultContent: ''},
            {targets: [3], width: '20%', data: 'weather', defaultContent: ''},
          ]
        });

        $('#exampleModal').on('shown.bs.modal', function (e) {
            $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
        });

        $('#exampleModal').modal('show');
      }
    }

    $(document).on('keypress',function(e) {
        let searchBar = $("input[type=search]").val();
        if(e.which == 13) {
            processInputData(searchBar);
        }
    });

    $(document).on("click", ":submit", function(e){
      let searchBar = $("input[type=search]").val();
      processInputData(searchBar);
    });
    

  });

  document.addEventListener('DOMContentLoaded', function(){
    var script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js';
    script.onload = function(){
      particlesJS("sakura", {
        "particles": {
          "number": {
            "value": 100,
            "density": {
              "enable": true,
              "value_area": 1000
            }
          },
          "color": {
            "value": "#fcc9b9"
          },
          "opacity": {
            "value": 0.9,
            "random": true,
            "anim": {
                "enable": false
            }
          },
          "size": {
            "value": 5,
            "random": true,
            "anim": {
                "enable": false
            }
          },
          "line_linked": {
            "enable": false
          },
          "move": {
            "enable": true,
            "speed": 1,
            "direction": "bottom",
            "random": true,
            "straight": false,
            "out_mode": "out",
            "bounce": false,
            "attract": {
                "enable": true,
                "rotateX": 300,
                "rotateY": 1200
            }
          }
        },
        "interactivity": {
          "events": {
            "onhover": {
              "enable": false
            },
            "onclick": {
              "enable": false
            },
            "resize": false
          }
        },
        "retina_detect": true
      });
    }

    document.head.append(script);
  });
</script>