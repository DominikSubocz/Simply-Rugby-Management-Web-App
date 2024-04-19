<td data-th="#"><input type="checkbox" name="check_list[]" class="cb" onchange="cbChange(this)"
    value="<?php echo $pageType . '.php?id=' . $eventId; ?>"></td>
<td onclick="location.href='<?php echo $pageType . '.php?id=' . $eventId; ?>'" data-th="First Name"
  class="first-name-label">
  <p><?php echo $name; ?></p>
</td>
<td onclick="location.href='<?php echo $pageType . '.php?id=' . $eventId; ?>'" data-th="Last Name" class="last-name-label">
  <p><?php echo $eventType; ?></p>
</td>
<td onclick="location.href='<?php echo $pageType . '.php?id=' . $eventId; ?>'" data-th="Contact No." class="contact-label">
  <p><?php echo $startDate; ?></p>
</td>
<td onclick="location.href='<?php echo $pageType . '.php?id=' . $eventId; ?>'" data-th="Address Line 1"
  class="address-line-1-label"><?php echo $endDate; ?></td>
<td onclick="location.href='<?php echo $pageType . '.php?id=' . $eventId; ?>'" data-th="Address Line 2"
  class="address-line-2-label"><?php echo $location; ?></td>
</tr>