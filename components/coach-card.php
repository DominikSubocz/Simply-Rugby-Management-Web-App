<tr class="hover-overlay">
        <td data-th="#"><input type="checkbox" name="check_list[]" class="cb" onchange="cbChange(this)"
                        value="<?php echo $coachId; ?>"></td>
        <td onclick="location.href='coach-page.php?id=<?php echo $coachId; ?>'" data-th="First Name"
                class="first-name-label">
                <p><?php echo $firstName; ?></p>
        </td>
        <td onclick="location.href='coach-page.php?id=<?php echo $coachId; ?>'" data-th="Last Name"
                class="last-name-label">
                <p><?php echo $lastName; ?></p>
        </td>
        <td onclick="location.href='coach-page.php?id=<?php echo $coachId; ?>'" data-th="Date of Birth"
                class="dob-label">
                <p><?php echo $dob; ?></p>
        </td>
        <td onclick="location.href='coach-page.php?id=<?php echo $coachId; ?>'" data-th="Contact No."
                class="contact-label">
                <p><?php echo $contactNo; ?></p>
        </td>
        <td onclick="location.href='coach-page.php?id=<?php echo $coachId; ?>'" data-th="Mobile No."
                class="mobile-label">
                <p><?php echo $mobileNumber; ?></p>
        </td>
        <td onclick="location.href='coach-page.php?id=<?php echo $coachId; ?>'" data-th="Email Address"
                class="email-label">
                <p><?php echo $emailAddress; ?></p>
        </td>
        <td onclick="location.href='coach-page.php?id=<?php echo $coachId; ?>'" data-th="Profile Picture"
                class="pfp-label"> <img src="images/<?php echo $filename; ?>" alt="Cover for <?php echo $firstName; ?>"
                        class="player-image"></td>
</tr>