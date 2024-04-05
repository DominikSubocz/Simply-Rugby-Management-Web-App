<tr class="hover-overlay" onclick="location.href='member-page.php?id=<?php echo $member_id; ?>'">
        <td data-th="#" ><input type="checkbox" name="check_list[]" class="cb" onchange="cbChange(this)" value="<?php echo $member_id; ?>"></td>
        <td data-th="First Name" class="first-name-label"><p><?php echo $firstName; ?></p></td>
        <td data-th="Last Name" class="last-name-label" ><p><?php echo $lastName; ?></p></td>
        <td data-th="SRU No." class="sru-label"><p><?php echo $sruNumber; ?></p></td>
        <td data-th="Date of Birth" class="dob-label"><p><?php echo $dob; ?></p></td>
        <td data-th="Contact No." class="contact-label"><p><?php echo $contactNumber; ?></p></td>
        <td data-th="Email Address" class="email-label"><p><?php echo $emailAddress; ?></p></td>
        <td data-th="Profile Picture" class="pfp-label">    <img src="images/<?php echo $filename; ?>" alt="Cover for <?php echo $firstName; ?>" class="player-image"></td>
    </a>
</tr>

