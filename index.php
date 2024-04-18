<?php
session_start();
include './utils/db_connection.php';
$sql = "SELECT * FROM tbl_product ORDER BY p_rating DESC LIMIT 3";
$result = $conn->query($sql);

// YouTube Data API configuration
$youtube_api_key = 'AIzaSyA9Gf0XIiQy7h2UurLcxbRZHoyZbHiTrCs';
$youtube_api_url = 'https://www.googleapis.com/youtube/v3/search?part=snippet&maxResults=1&q=microwave+oven+review&type=video&key=' . $youtube_api_key;

// Fetch video data from YouTube Data API
$youtube_response = file_get_contents($youtube_api_url);
$youtube_data = json_decode($youtube_response, true);
$video_id = $youtube_data['items'][0]['id']['videoId'];
$video_title = $youtube_data['items'][0]['snippet']['title'];
$video_description = $youtube_data['items'][0]['snippet']['description'];
?>
<!DOCTYPE html>
<html lang="en">

<?php include 'head.php' ?>

<body>
  <!-- Navbar -->
  <?php include 'navbar.php' ?>
  <header>
    <div style="height: max-content;background-color: white;">
      <h1>BAKE.<span> GRILL </span>.TOAST</h1>
      <h3>FIND THE BEST OVENS <span>!</span></h3>
    </div>
  </header>

  <main>
    <div id="sec-1">
      <h2>OUR TOP SELLING OVENS</h2>
      <?php
      while ($row = $result->fetch()) {
        echo '<div class="card">';
        echo '<a href="product_details.php?id=' . $row["p_id"] . '"><img src="./images/' . $row["p_image"] . '" alt="' . $row["p_name"] . '" /></a>';
        echo '<p>' . $row["p_name"] . ' </p>';
        echo '</div>';
      }
      ?>
      <a href="products.php"><button type="button" class="button1">See More</button></a>
    </div>

    <div id="sec-3">
      <div class="subsec3">
        <h2>Summer Deals </h2>
        <p>
          Discover sizzling summer savings at Oven Store! Get hot deals on top-of-the-line ovens for your kitchen upgrade. Don't miss out—shop now and cook up the perfect summer feast!
        </p>
        <a href="products.php"><button type="button">Browse Oven </button></a>
      </div>

      <div class="subsec3">
        <h2>Latest Microwave Oven Reviews</h2>
        <iframe width="100%" height="400" src="https://www.youtube.com/embed/<?php echo $video_id; ?>" frameborder="0" allowfullscreen></iframe>
        <h3><?php echo $video_title; ?></h3>
        <p><?php echo $video_description; ?></p>
      </div>

    </div>
  </main>
  <?php include 'footer.php' ?>
</body>

</html>