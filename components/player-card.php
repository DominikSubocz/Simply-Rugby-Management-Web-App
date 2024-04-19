<tr class="hover-overlay">
        <td data-th="#"><input type="checkbox" name="check_list[]" class="cb" onchange="cbChange(this)"
                        value="<?php echo $player_id; ?>"></td>
        <td onclick="location.href='player.php?id=<?php echo $player_id; ?>'" data-th="First Name"
                class="first-name-label">
                <p><?php echo $firstName; ?></p>
        </td>
        <td onclick="location.href='player.php?id=<?php echo $player_id; ?>'" data-th="Last Name"
                class="last-name-label">
                <p><?php echo $lastName; ?></p>
        </td>
        <td onclick="location.href='player.php?id=<?php echo $player_id; ?>'" data-th="SRU No." class="sru-label">
                <p><?php echo $sruNumber; ?></p>
        </td>
        <td onclick="location.href='player.php?id=<?php echo $player_id; ?>'" data-th="Date of Birth" class="dob-label">
                <p><?php echo $dob; ?></p>
        </td>
        <td onclick="location.href='player.php?id=<?php echo $player_id; ?>'" data-th="Contact No."
                class="contact-label">
                <p><?php echo $contactNumber; ?></p>
        </td>
        <td onclick="location.href='player.php?id=<?php echo $player_id; ?>'" data-th="Email Address"
                class="email-label">
                <p><?php echo $emailAddress; ?></p>
        </td>
        <td onclick="location.href='player.php?id=<?php echo $player_id; ?>'" data-th="Profile Picture"
                class="pfp-label"> <img src="images/<?php echo $filename; ?>" alt="Cover for <?php echo $firstName; ?>"
                        class="player-image"></td>
</tr>