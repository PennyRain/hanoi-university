<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Hà Nội</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v7.1.0/ol.css" type="text/css" />
  <script src="https://cdn.jsdelivr.net/npm/ol@v7.1.0/dist/ol.js" type="text/javascript"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdn.usebootstrap.com/bootstrap/4.0.0/css/bootstrap.min.css" type="text/css" />
  <script src="https://cdn.usebootstrap.com/bootstrap/4.0.0/js/bootstrap.min.js" type="text/javascript"></script>
  <script src="script.js" type="text/javascript"></script>
  <link rel="stylesheet" href="style.css" type="text/css" />


</head>
<body>
  <div class="header container-fluid flex">
    <div class="col-md-1">
      <img src="src/logomap.png" class="logo"  height="48">
    </div>
    <div class="col-md-6 title-web">
      <h2>Bản Đồ Thành Phố Hà Nội</h2>
    </div>
    <div class="col-md-5 col-md-offset-3 title-web">
      <p class="input-radio-header">
        <input type="radio" id="test1" name="HN" value="HN6">
        <label for="test1">Quận Huyện/Thị Xã</label>
      </p>
     
      <p class="input-radio-header">
        <input type="radio" id="test4" name="HN" value="RHN">
        <label for="test4">Đường Xá</label>
      </p>
      <p class="input-radio-header">
        <input type="radio" id="test3" name="HN" value="HSHN">
        <label for="test3">Trường</label>
      </p>
    </div>
  </div>
  <div class="container-fluid">
    <div class="row">

      <div class="side-bar">
        <div>
         
        </div>
      </div>
      <div class="content">
        <div class="map-area col-md-12">
        
          <div class="row">

            <div id = "map"></div>
          </div>


          <!-- Btn  -->
          <button id = "btnSOS" class="btnSOS">
            <img src="src/sos.png" class="btn-sos-1">
          </button>
          <button id = "btnPos" class="btnPos">
            <img src="src/search-location.svg.png" class="btn-pos-1">
          </button>
          <!--  -->

          
          <!-- END Info Hà Nội  -->
          <div class="end">
                            <form method="POST"> 
                                <input type="text" name="search" placeholder="Tìm kiếm " style="width: 500px; border: 2px solid ; border-radius:3px ;">
                                <input type="submit" name="submit" value="Tìm" style="width: 80px;border: 2px solid ; border-radius:3px ;">  
                                <input type="submit" name="submitAll" value="Hiển thị tất cả" style="border: 2px solid ; border-radius:3px ;">    
                            </form>
                        </div>
          <!-- Info unviversity -->
          <button class="btn btn-info-bvhn detail-hopital" type="button" data-toggle="collapse" data-target="#infoBVHN" aria-expanded="false" aria-controls="infoBVHN">
            <img src="src/info.png" class="img-btn-info-bv">
          </button>
          <div class="info-area-modal-bvhn">
            <div class="collapse" id="infoBVHN">
              <div class="card card-body">
                <div class="header-info">
                  <h1>Hệ Thống Bản Đồ </h1>
                </div>
                <div class="body-info">
                  <img src="" id="imgHSHN" class="img-demo-hn">

                  <div id="infoHSHN">

                  </div>

                </div>
              </div>
            </div>
          </div>
          <!-- END Info unviversity -->
          <div class="mode-area">
            <button class="btn btn-primary group-layer" type="button" data-toggle="collapse" data-target="#1" aria-expanded="false" aria-controls="1">
              Group Layer
            </button>
            <div class="collapse" id="1">

              <input type="checkbox" class = "col-md-2" id="HN4"><label class="col-md-10">Tỉnh</label>
              <input type="checkbox" class = "col-md-2" id="HN6"><label class="col-md-10">Quận Huyện/Thị Xã</label>
              <input type="checkbox" class = "col-md-2" id="RHN"><label class="col-md-10">Hệ thống đường xá</label>
              <input type="checkbox" class = "col-md-2" id="HSHN"><label class="col-md-10">Hệ thống các trường</label>
            </div>
          </div>
        </div>
        
        </div>
        <div class="info-area">
          <div id="info"></div>
        </div>
      </div>
    </div>
  </div>
 
  <div id="overlay"></div>
  <div id="location"><img src = "src/pos.png"></div>
  <?php include 'API.php' ?>
        <?php
            if(isset($_POST['submit'])){
                $search = $_POST['search'];
                getSearch($search);
            }
            if(isset($_POST['submitAll'])){
                
                getSearch("");
            }
        ?>
  </body>
  </html>
