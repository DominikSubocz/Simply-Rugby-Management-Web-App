
<div>
    
<table class="table" id="customDataTable">
  <thead>
  <h2><?php echo 'Half Number: '. $gameHalfNumber; ?></h2>

    <tr>
      <th class="home-score-label">Home Score</th>
      <th class="home-comment-label">Home Comment</th>
      <th class="opposition-score-label">Opposition Score</th>
      <th class="opposition-comment-label">Opposition Comment</th>

    </tr>
  </thead>
  <tbody>

    <tr class="hover-overlay" >
            <td data-th="Home Score" class="home-score-label"><p><?php echo $homeScore; ?></p></td>
            <td data-th="Home Comments" class="home-comment-label"><p><?php echo 'Accidents: '.$homeComment; ?></p></td>
            <td data-th="Opposition Score" class="opposition-score-label"><p><?php echo 'Injuries: '.$oppositionScore; ?></p></td>
            <td data-th="Opposition Comments" class="oppotision-comment-label"><p><?php echo 'Injuries: '.$oppositionComment ; ?></p></td>
        </a>
    </tr>

  </tbody>
</table>
</div>





