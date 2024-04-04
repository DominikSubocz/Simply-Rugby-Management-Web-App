<div class="address-card">

<div class="id-container card-container">
  <td><input type="checkbox" name="check_list[]" class="cb" onchange="cbChange(this)" value="<?php echo $addressId; ?>"></td>
  </div>

  <div class="address-line1-container card-container">
    <p><?php echo $addressLine; ?></p>
  </div>

  <div class="address-line2-container card-container">
      <p class="player-price"><?php echo $addressLine2; ?></p>
  </div>
  
  <div class="city-container card-container">
      <p class="player-price"><?php echo $city; ?></p>
  </div>

  <div class="county-container card-container">
      <p class="player-price"><?php echo $county; ?></p>
  </div>

  <div class="postcode-container card-container">
      <p class="player-price"><?php echo $postcode; ?></p>
  </div>

</div>

