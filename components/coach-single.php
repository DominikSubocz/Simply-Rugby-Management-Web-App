<main class="content-wrapper profile-content">

    <div class="profile-content-container">
        <div class="profile-container">
            <div class="profile-items">
                <h2>Personal Details</h2>
                <img class="profile-img" src="images/<?php echo $filename; ?>" alt="Cover of <?php echo $firstName; ?>"
                    class="profile-img">
                <p><?php echo 'Name: ', $firstName, ' ', $lastName; ?></p>
                <p><?php echo 'Contact Number: ', $contactNo; ?></p>
                <p><?php echo 'Mobile Number: ', $mobileNumber; ?></p>
                <p><?php echo 'Email: ', $emailAddress; ?></p>
            </div>
        </div>
    </div>


</main>