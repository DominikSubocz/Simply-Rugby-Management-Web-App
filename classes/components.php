<?php

class Components {
  /**
   * Output a standard page header with customisable options.
   *
   * $pageTitle - string
   * $stylesheets - array
   * $scripts - array
   */
  public static function pageHeader($pageTitle, $stylesheets, $scripts) {
    require("components/header.php");
  }

  public static function blankPageHeader($pageTitle, $stylesheets, $scripts) {
    require("components/header-blank.php");
  }


  /**
   * Output a standard page footer.
   */
  public static function pageFooter() {
    require("components/footer.php");
  }

  /**
   * Renders an array of player arrays as a gallery.
   */
  public static function allPlayers($players)
  {
    if (!empty($players)) {
      // Output a player card for each player in the $players array
      foreach ($players as $player) {
        $player_id = Utils::escape($player["player_id"]);
        $address_id = Utils::escape($player["address_id"]);
        $user_id = Utils::escape($player["user_id"]);
        $doctor_id = Utils::escape($player["doctor_id"]);
        $firstName = Utils::escape($player["first_name"]);
        $lastName = Utils::escape($player["last_name"]);
        $dob = Utils::escape($player["dob"]);
        $sruNumber = Utils::escape($player["sru_no"]);
        $contactNumber = Utils::escape($player["contact_no"]);
        $mobileNumber = Utils::escape($player["mobile_no"]);
        $emailAddress = Utils::escape($player["email_address"]);
        $nextOfKin = Utils::escape($player["next_of_kin"]);
        $kinContactNumber = Utils::escape($player["kin_contact_no"]);
        $healthIssues = Utils::escape($player["health_issues"]);
        $filename = Utils::escape($player["filename"]);


        require("components/player-card.php");
      }
    } else {
      // Output a message if the $players array is empty
      require("components/no-players-found.php");
    }
  }

  public static function allGuardians($guardians){
    if(!empty($guardians)){
      foreach($guardians as $guardian){
        $guardianId = Utils::escape($guardian["guardian_id"]);
        $firstName = Utils::escape($guardian["guardian_first_name"]);
        $lastName = Utils::escape($guardian["guardian_last_name"]);
        $contactNumber = Utils::escape($guardian["guardian_contact_no"]);

        $address1 = Utils::escape($guardian["address_line"]);
        $address2 = Utils::escape($guardian["address_line2"]);
        $city = Utils::escape($guardian["city"]);
        $county = Utils::escape($guardian["county"]);
        $postcode = Utils::escape($guardian["postcode"]);

        require("components/guardian-card.php");

      }
    }

  }

  public static function singleCoach($coach){
    if (!empty($coach)) {
      $coachId = Utils::escape($coach["coach_id"]);
      $firstName = Utils::escape($coach["first_name"]);
      $lastName = Utils::escape($coach["last_name"]);
      $dob = Utils::escape($coach["dob"]);
      $contactNo = Utils::escape($coach["contact_no"]);
      $mobileNumber = Utils::escape($coach["mobile_no"]);
      $emailAddress = Utils::escape($coach["email_address"]);
      $filename = Utils::escape($coach["filename"]);
      require("components/coach-single.php");

    }

  }

  public static function allDoctors($doctors){
    if (!empty($doctors)) {
      foreach ($doctors as $doctor) {
        $doctorId = Utils::escape($doctor["doctor_id"]);
        $firstName = Utils::escape($doctor["doctor_first_name"]);
        $lastName = Utils::escape($doctor["doctor_last_name"]);
        $contactNumber = Utils::escape($doctor["doctor_contact_no"]);

        require("components/doctor-card.php");

      }
  }
}

  public static function allAddresses($addresses)
  {
    if (!empty($addresses)) {
      foreach ($addresses as $address) {
        $addressId = Utils::escape($address["address_id"]);
        $addressLine = Utils::escape($address["address_line"]);
        $addressLine2 = Utils::escape($address["address_line2"]);
        $city = Utils::escape($address["city"]);
        $county = Utils::escape($address["county"]);
        $postcode = Utils::escape($address["postcode"]);



        require("components/address-card.php");
      }
    } else {
      require("components/no-players-found.php");
    }
  }

  /**
   * Renders a player array to the page.
   */
  public static function singleplayer($player)
  {
    if (!empty($player)) {
      $player_id = Utils::escape($player["player_id"]);
      $address_id = Utils::escape($player["address_id"]);
      $dob = Utils::escape($player["dob"]);
      $user_id = Utils::escape($player["user_id"]);
      $doctor_id = Utils::escape($player["doctor_id"]);
      $firstName = Utils::escape($player["first_name"]);
      $lastName = Utils::escape($player["last_name"]);
      $sruNumber = Utils::escape($player["sru_no"]);
      $contactNumber = Utils::escape($player["contact_no"]);
      $mobileNumber = Utils::escape($player["mobile_no"]);
      $emailAddress = Utils::escape($player["email_address"]);
      $healthIssues = Utils::escape($player["health_issues"]);
      $filename = Utils::escape($player["filename"]);
      $nextOfKin = Utils::escape($player["next_of_kin"]);
      $kinContactNumber = Utils::escape($player["kin_contact_no"]);
      $address1 = Utils::escape($player["address_line"]);
      $address2 = Utils::escape($player["address_line2"]);
      $city = Utils::escape($player["city"]);
      $county = Utils::escape($player["county"]);
      $postcode = Utils::escape($player["postcode"]);
      $doctorFirstName = Utils::escape($player["doctor_first_name"]);
      $doctorLastName = Utils::escape($player["doctor_last_name"]);
      $doctorContact = Utils::escape($player["doctor_contact_no"]);

      // Output information on a single player
      require("components/player-single.php");
    } else {
      // Output a message if the $players array is empty
      require("components/no-single-player-found.php");
    }
  }

  public static function allJuniors($juniors)
  {
    if (!empty($juniors)) {
      // Output a player card for each player in the $players array
      foreach ($juniors as $junior) {
        $junior_id = Utils::escape($junior["junior_id"]);
        $address_id = Utils::escape($junior["address_id"]);
        $user_id = Utils::escape($junior["user_id"]);
        $firstName = Utils::escape($junior["first_name"]);
        $lastName = Utils::escape($junior["last_name"]);
        $dob = Utils::escape($junior["dob"]);
        $sruNumber = Utils::escape($junior["sru_no"]);
        $contactNumber = Utils::escape($junior["contact_no"]);
        $mobileNumber = Utils::escape($junior["mobile_no"]);
        $emailAddress = Utils::escape($junior["email_address"]);
        $healthIssues = Utils::escape($junior["health_issues"]);
        $filename = Utils::escape($junior["filename"]);



        require("components/junior-card.php");
      }
    } else {
      // Output a message if the $players array is empty
      require("components/no-players-found.php");
    }
  }

    /**
   * Renders a player array to the page.
   */
  public static function singleJunior($junior)
  {
    if (!empty($junior)) {
      $junior_id = Utils::escape($junior["junior_id"]);
      $address_id = Utils::escape($junior["address_id"]);
      $user_id = Utils::escape($junior["user_id"]);
      $firstName = Utils::escape($junior["first_name"]);
      $lastName = Utils::escape($junior["last_name"]);
      $sruNumber = Utils::escape($junior["sru_no"]);
      $contactNumber = Utils::escape($junior["contact_no"]);
      $mobileNumber = Utils::escape($junior["mobile_no"]);
      $emailAddress = Utils::escape($junior["email_address"]);
      $healthIssues = Utils::escape($junior["health_issues"]);
      $filename = Utils::escape($junior["filename"]);

      $address1 = Utils::escape($junior["address_line"]);
      $address2 = Utils::escape($junior["address_line2"]);
      $city = Utils::escape($junior["city"]);
      $county = Utils::escape($junior["county"]);
      $postcode = Utils::escape($junior["postcode"]);

      $doctorFirstName = Utils::escape($junior["doctor_first_name"]);
      $doctorLastName = Utils::escape($junior["doctor_last_name"]);
      $doctorContact = Utils::escape($junior["doctor_contact_no"]);


      // Output information on a single player
      require("components/junior-single.php");
    } else {
      // Output a message if the $players array is empty
      require("components/no-single-player-found.php");
    }
  }

  public static function juniorGuardians($juniors)
  {
    if (!empty($juniors)) {
      // Output a player card for each player in the $players array
      foreach ($juniors as $junior) {
        $guardianFirstName = Utils::escape($junior["guardian_first_name"]);
        $guardianLastName = Utils::escape($junior["guardian_last_name"]);
        $guardianContactNum = Utils::escape($junior["guardian_contact_no"]);
        $relationship = Utils::escape($junior["relationship"]);

        require("components/guardian-single.php");




      }
    } else {
      // Output a message if the $players array is empty
      require("components/no-players-found.php");
    }
  }

  public static function juniorPassingSkill($juniors)
  {
    if (!empty($juniors)) {
      // Output a player card for each player in the $players array
      foreach ($juniors as $junior) {
        $skillCategory = Utils::escape($junior["category"]);
        $skillName = Utils::escape($junior["skill_name"]);
        $skillLevel = Utils::escape($junior["skill_level"]);
        $comment = Utils::escape($junior["comment"]);

        if($skillCategory == "Passing"){
          require("components/junior-skill.php");
        }



      }
    } else {
      // Output a message if the $players array is empty
      require("components/no-players-found.php");
    }
  }

  public static function juniorTacklingSkill($juniors)
  {
    if (!empty($juniors)) {
      // Output a player card for each player in the $players array
      foreach ($juniors as $junior) {
        $skillCategory = Utils::escape($junior["category"]);
        $skillName = Utils::escape($junior["skill_name"]);
        $skillLevel = Utils::escape($junior["skill_level"]);
        $comment = Utils::escape($junior["comment"]);

        if($skillCategory == "Tackling"){
          require("components/junior-skill.php");
        }



      }
    } else {
      // Output a message if the $players array is empty
      require("components/no-players-found.php");
    }
  }

  public static function juniorKickingSkill($juniors)
  {
    if (!empty($juniors)) {
      // Output a player card for each player in the $players array
      foreach ($juniors as $junior) {
        $skillCategory = Utils::escape($junior["category"]);
        $skillName = Utils::escape($junior["skill_name"]);
        $skillLevel = Utils::escape($junior["skill_level"]);
        $comment = Utils::escape($junior["comment"]);

        if($skillCategory == "Kicking"){
          require("components/junior-skill.php");
        }



      }
    } else {
      // Output a message if the $players array is empty
      require("components/no-players-found.php");
    }
  }

  public static function playerPassingSkill($players)
  {
    if (!empty($players)) {
      // Output a player card for each player in the $players array
      foreach ($players as $player) {
        $skillCategory = Utils::escape($player["category"]);
        $skillName = Utils::escape($player["skill_name"]);
        $skillLevel = Utils::escape($player["skill_level"]);
        $comment = Utils::escape($player["comment"]);

        if($skillCategory == "Passing"){
          require("components/junior-skill.php");
        }



      }
    } else {
      // Output a message if the $players array is empty
      require("components/no-players-found.php");
    }
  }

  public static function playerTacklingSkill($players)
  {
    if (!empty($players)) {
      // Output a player card for each player in the $players array
      foreach ($players as $player) {
        $skillCategory = Utils::escape($player["category"]);
        $skillName = Utils::escape($player["skill_name"]);
        $skillLevel = Utils::escape($player["skill_level"]);
        $comment = Utils::escape($player["comment"]);

        if($skillCategory == "Tackling"){
          require("components/junior-skill.php");
        }



      }
    } else {
      // Output a message if the $players array is empty
      require("components/no-players-found.php");
    }
  }

  public static function playerKickingSkill($players)
  {
    if (!empty($players)) {
      // Output a player card for each player in the $players array
      foreach ($players as $player) {
        $skillCategory = Utils::escape($player["category"]);
        $skillName = Utils::escape($player["skill_name"]);
        $skillLevel = Utils::escape($player["skill_level"]);
        $comment = Utils::escape($player["comment"]);

        if($skillCategory == "Kicking"){
          require("components/junior-skill.php");
        }



      }
    } else {
      // Output a message if the $players array is empty
      require("components/no-players-found.php");
    }
  }

  public static function juniorPositions($juniors)
  {
    if (!empty($juniors)) {
      // Output a player card for each player in the $players array
      foreach ($juniors as $junior) {
        $position = Utils::escape($junior["position"]);


        require("components/junior-positions.php");




      }
    } else {
      // Output a message if the $players array is empty
      require("components/no-players-found.php");
    }
  }

  public static function playerPositions($players)
  {
    if (!empty($players)) {
      // Output a player card for each player in the $players array
      foreach ($players as $player) {
        $position = Utils::escape($player["position"]);


        require("components/junior-positions.php");




      }
    } else {
      // Output a message if the $players array is empty
      require("components/no-players-found.php");
    }
  }



  public static function allMembers($members)
  {
    if (!empty($members)) {
      // Output a player card for each player in the $players array
      foreach ($members as $member) {
        $member_id = Utils::escape($member["member_id"]);
        $address_id = Utils::escape($member["address_id"]);
        $user_id = Utils::escape($member["user_id"]);
        $firstName = Utils::escape($member["first_name"]);
        $lastName = Utils::escape($member["last_name"]);
        $dob = Utils::escape($member["dob"]);
        $sruNumber = Utils::escape($member["sru_no"]);
        $contactNumber = Utils::escape($member["contact_no"]);
        $mobileNumber = Utils::escape($member["mobile_no"]);
        $emailAddress = Utils::escape($member["email_address"]);
        $filename = Utils::escape($member["filename"]);






        require("components/member-card.php");
      }
    } else {
      // Output a message if the $players array is empty
      require("components/no-players-found.php");
    }
  }

  /**
   * Renders a player array to the page.
   */
  public static function singleMember($member)
  {
    if (!empty($member)) {
      $member_id = Utils::escape($member["member_id"]);
      $address_id = Utils::escape($member["address_id"]);
      $user_id = Utils::escape($member["user_id"]);
      $firstName = Utils::escape($member["first_name"]);
      $lastName = Utils::escape($member["last_name"]);
      $sruNumber = Utils::escape($member["sru_no"]);
      $contactNumber = Utils::escape($member["contact_no"]);
      $mobileNumber = Utils::escape($member["mobile_no"]);
      $emailAddress = Utils::escape($member["email_address"]);
      $filename = Utils::escape($member["filename"]);

      $address1 = Utils::escape($member["address_line"]);
      $address2 = Utils::escape($member["address_line2"]);
      $city = Utils::escape($member["city"]);
      $county = Utils::escape($member["county"]);
      $postcode = Utils::escape($member["postcode"]);


      // Output information on a single player
      require("components/member-single.php");
    } else {
      // Output a message if the $players array is empty
      require("components/no-single-player-found.php");
    }
  }

  public static function allEvents($events){
    if (!empty($events)) {
      // Output a player card for each player in the $players array
      foreach ($events as $event) {

        $type = Utils::escape($event["type"]); // Retrieve the type of event

        if($type == "game_id"){
          $eventType = "Game";
          $pageType = "game";

        } else {
          $eventType = "Training Session";
          $pageType = "session";
        }

        $eventId = Utils::escape($event["id"]);

        $name = Utils::escape($event["name"]);
        $startDate = Utils::escape($event["start"]);
        $endDate = Utils::escape($event["end"]);
        $location = Utils::escape($event["location"]);



        require("components/event-card.php");
      }
    } 
  }

  public static function singleGame($game)
  {
    if (!empty($game)) {
      $gameId = Utils::escape($game["game_id"]);
      $squadId = Utils::escape($game["squad_id"]);
      $gameName = Utils::escape($game["name"]);
      $oppositionName = Utils::escape($game["opposition_team"]);
      $gameStart = Utils::escape($game["start"]);
      $gameEnd = Utils::escape($game["end"]);
      $gameLocation = Utils::escape($game["location"]);
      $gameKickoff = Utils::escape($game["kickoff_time"]);
      $gameResult = Utils::escape($game["result"]);
      $gameScore = Utils::escape($game["score"]);







      // Output information on a single player
      require("components/game-single.php");
    }
  }

  public static function gameHalves($gameHalves){

    if(!empty($gameHalves)){
      foreach($gameHalves as $gameHalf){

        $gameHalfId = Utils::escape($gameHalf["game_half_id"]);
        $gameHalfNumber = Utils::escape($gameHalf["half_number"]);
        $homeTeam = Utils::escape($gameHalf["home_team"]);
        $homeScore =  Utils::escape($gameHalf["home_score"]);
        $homeComment = Utils::escape($gameHalf["home_comment"]);
        $oppositionScore = Utils::escape($gameHalf["opposition_score"]);
        $oppositionComment = Utils::escape($gameHalf["opposition_comment"]);

        require("components/game-half-single.php");

      } 
    }

  }

  public static function trainingDetails($trainingDetails){

    if(!empty($trainingDetails)){
      foreach($trainingDetails as $trainingDetail){

        $trainingDetailId = Utils::escape($trainingDetail["training_details_id"]);
        $sessionId = Utils::escape($trainingDetail["session_id"]);
        $coachId = Utils::escape($trainingDetail["coach_id"]);
        $squadId =  Utils::escape($trainingDetail["squad_id"]);
        $skills = Utils::escape($trainingDetail["skills"]);
        $activities = Utils::escape($trainingDetail["activities"]);
        $presentPlayers = Utils::escape($trainingDetail["present_players"]);
        $accidents = Utils::escape($trainingDetail["accidents"]);
        $injuries = Utils::escape($trainingDetail["injuries"]);

        require("components/training-detail-single.php");

      } 
    }

  }

  public static function singleSession($session)
  {
    if (!empty($session)) {
      $sessionId = Utils::escape($session["session_id"]);
      $coachId = Utils::escape($session["coach_id"]);
      $squadId = Utils::escape($session["squad_id"]);
      $sessionName = Utils::escape($session["name"]);
      $sessionStart = Utils::escape($session["start"]);
      $sessionEnd = Utils::escape($session["end"]);
      $sessionLocation = Utils::escape($session["location"]);






      // Output information on a single player
      require("components/session-single.php");
    } else {
      // Output a message if the $players array is empty
      require("components/no-single-player-found.php");
    }
  }
}
