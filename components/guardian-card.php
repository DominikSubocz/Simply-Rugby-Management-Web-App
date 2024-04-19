<tr>
  <td data-th="#"><input type="checkbox" name="check_list[]" class="cb" onchange="cbChange(this)"
      value="<?php echo $guardianId; ?>"></td>
  <td data-th="First Name" class="first-name-label">
    <p><?php echo $firstName; ?></p>
  </td>
  <td data-th="Last Name" class="last-name-label">
    <p><?php echo $lastName; ?></p>
  </td>
  <td data-th="Contact No." class="contact-label">
    <p><?php echo $contactNumber; ?></p>
  </td>
  <td data-th="Address Line 1" class="address-line-1-label"><?php echo $address1; ?></td>
  <td data-th="Address Line 2" class="address-line-2-label"><?php echo $address2; ?></td>
  <td data-th="City" class="city-label"><?php echo $city; ?></td>
  <td data-th="County" class="county-label"><?php echo $county; ?></td>
  <td data-th="Postcode" class="postcode-label"><?php echo $postcode; ?></td>
</tr>