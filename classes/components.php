<?php

/**
 * 
 * @brief This class is responsible for displaying right components of the webapp.
 * 
 * These include:
 *  - Header & Footer.
 *  - Card containers.
 *  - Single Profile Pages.
 *  
 * Future Additions:
 *  @todo - Possibly more components, and some tweaks :)
 */

class Components {
  /**
   * Output a standard page header with customisable options.
   *
   * $pageTitle - string - Title of the page.
   * $stylesheets - array - List of stylesheets.
   * $scripts - array - List of scripts.
   */
  public static function pageHeader($pageTitle, $stylesheets, $scripts) {
    require("components/header.php"); ///< Output header component.
  }

  public static function blankPageHeader($pageTitle, $stylesheets, $scripts) {
    require("components/header-blank.php"); ///< Output blank header component.
  }


  /**
   * Output a standard page footer.
   */
  public static function pageFooter() {
    require("components/footer.php"); ///< Output footer component.
  }


  /**
   *  Renders an array of player as table rows.
   *  
   *  @param players - Array containing all records from the Players table.
   *  
   */
  public static function allPlayers($players)
  {
    if (!empty($players)) {
      /// Output a player card for each player in the $players array
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


        require("components/player-card.php"); ///< Output information on each player.
      }
    } else {
       
      require("components/no-players-found.php"); ///< Output a message if the $players array is empty
    }
  }

  /**
   *  Renders an array of coaches as table rows.
   * 
   *  @param coaches - Array containing all records from the Coaches table.
   *  
   */

  public static function allCoaches($coaches)
  {
    if (!empty($coaches)) {
      /// Output a coach card for each coach in the $coaches array
      foreach ($coaches as $coach) {
        $coachId = Utils::escape($coach["coach_id"]);
        $firstName = Utils::escape($coach["first_name"]);
        $lastName = Utils::escape($coach["last_name"]);
        $dob = Utils::escape($coach["dob"]);
        $contactNo = Utils::escape($coach["contact_no"]);
        $mobileNumber = Utils::escape($coach["mobile_no"]);
        $emailAddress = Utils::escape($coach["email_address"]);
        $filename = Utils::escape($coach["filename"]);

        require("components/coach-card.php"); ///< Output information on each coach.
      }
    } 
  }

  /**
   *  Renders an array of guardians as table rows. 
   * 
   *  @param guardians - Array containing all records from the JOIN SQL command, which joins Guardians and Addresses tables.
   *  
   */

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

        require("components/guardian-card.php"); ///< Output information on each guardian.

      }
    }

  }


  /**
   *  Renders single coach record string as a individual profile page
   * 
   *  @param coach - String containing single record from the coaches table.
   *  
   */

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

      require("components/coach-single.php"); ///< Output information on single coach.

    }

  }

  /**
   *  Renders an array of doctors as table rows. 
   * 
   *  @param doctors - Array containing all records from the Doctors table.
   *  
   */

  public static function allDoctors($doctors){
    if (!empty($doctors)) {
      foreach ($doctors as $doctor) {
        $doctorId = Utils::escape($doctor["doctor_id"]);
        $firstName = Utils::escape($doctor["doctor_first_name"]);
        $lastName = Utils::escape($doctor["doctor_last_name"]);
        $contactNumber = Utils::escape($doctor["doctor_contact_no"]);

        require("components/doctor-card.php"); ///< Output information on each doctor.

      }
  }
}

  /**
   *  Renders an array of addresses as table rows. 
   * 
   *  @param addresses - Array containing all records from the Addresses table.
   *  
   */

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



        require("components/address-card.php"); ///< Output information on each address 
      }
    } else {
      require("components/no-players-found.php"); ///< Output a message if the $addresses array is empty
    }
  }

  /**
   *  Renders single player record string as a individual profile page
   * 
   *  @param player - String containing single record from the Players table.
   *  
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

       
      require("components/player-single.php"); ///< Output information on a single player
    } else {
       
      require("components/no-single-player-found.php");  ///< Output a message if the $players array is empty
    }
  }

  /**
   *  Renders an array of juniors as table rows. 
   * 
   *  @param juniors - Array containing all records from the Juniors table.
   *  
   */

  public static function allJuniors($juniors)
  {
    if (!empty($juniors)) {
      /// Output a junior player card for each junior player in the $juniors array
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



        require("components/junior-card.php"); ///<  Output information on each junior.
      }
    } else {
      require("components/no-players-found.php");  ///< Output a message if the $juniors array is empty
    }
  }

  /**
   *  Renders single junior player record string as a individual profile page
   * 
   *  @param junior - String containing single record from the Juniors table.
   *  
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


      require("components/junior-single.php"); ///<  Output information on a single junior
    } else {
       
      require("components/no-single-player-found.php"); ///< Output a message if the $juniors array is empty
    }
  }

  /**
   *  
   *  Renders an array of guardians as a div card
   * 
   *  @param juniors - Array containing all records from the JOIN SQL command, which joins Junior_associations and Guardians tables.
   *  
   */

  public static function juniorGuardians($juniors)
  {
    if (!empty($juniors)) {
      /// Output a guardian card for each junior player in the $juniors array
      foreach ($juniors as $junior) {
        $guardianFirstName = Utils::escape($junior["guardian_first_name"]);
        $guardianLastName = Utils::escape($junior["guardian_last_name"]);
        $guardianContactNum = Utils::escape($junior["guardian_contact_no"]);
        $relationship = Utils::escape($junior["relationship"]);

        require("components/guardian-single.php"); ///<  Output information on a each Guardians associated with a Junior.




      }
    } else {
       
      require("components/no-players-found.php"); ///<  Output a message if the $juniors array is empty
    }
  }

  /**
   *  Only renders an array of junior skills as a div card that are under the "Passing Category"
   * 
   *  @param juniors - Array containing all records from the Juniors table.
   *  
   */

  public static function juniorPassingSkill($juniors)
  {
    if (!empty($juniors)) {
      /// Output a junior skill card for each junior in the $juniors array
      foreach ($juniors as $junior) {
        $skillCategory = Utils::escape($junior["category"]);
        $skillName = Utils::escape($junior["skill_name"]);
        $skillLevel = Utils::escape($junior["skill_level"]);
        $comment = Utils::escape($junior["comment"]);

        if($skillCategory == "Passing"){
          require("components/junior-skill.php"); ///<  Output information on a each junior skill under "Passing" category
        }



      }
    } else {
      
      require("components/no-players-found.php"); ///< Output a message if the $juniors array is empty
    }
  }


  /**
   *  Only renders an array of junior skills as a div card that are under the "Tackling Category"
   * 
   *  @param juniors - Array containing all records from the Juniors table.
   *  
   */
  public static function juniorTacklingSkill($juniors)
  {
    if (!empty($juniors)) {
      /// Output a junior skill card for each junior in the $juniors array
      foreach ($juniors as $junior) {
        $skillCategory = Utils::escape($junior["category"]);
        $skillName = Utils::escape($junior["skill_name"]);
        $skillLevel = Utils::escape($junior["skill_level"]);
        $comment = Utils::escape($junior["comment"]);

        if($skillCategory == "Tackling"){
          require("components/junior-skill.php"); ///<  Output information on a each junior skill under "Tackling" category
        }



      }
    } else {
      
      require("components/no-players-found.php"); ///< Output a message if the $juniors array is empty
    }
  }


  /**
   *  Only renders an array of junior skills as a div card that are under the "Kicking Category"
   * 
   *  @param juniors - Array containing all records from the Juniors table.
   *  
   */
  public static function juniorKickingSkill($juniors)
  {
    if (!empty($juniors)) {
      /// Output a junior skill card for each junior in the $juniors array
      foreach ($juniors as $junior) {
        $skillCategory = Utils::escape($junior["category"]);
        $skillName = Utils::escape($junior["skill_name"]);
        $skillLevel = Utils::escape($junior["skill_level"]);
        $comment = Utils::escape($junior["comment"]);

        if($skillCategory == "Kicking"){
          require("components/junior-skill.php"); ///<  Output information on a each junior skill under "Kicking" category
        }



      }
    } else {
       
      require("components/no-players-found.php"); ///< Output a message if the $juniors array is empty
    }
  }

  /**
   *  Only renders an array of player skills as a div card that are under the "Passing Category"
   * 
   *  @param players - Array containing all records from the Players table.
   *  
   */

  public static function playerPassingSkill($players)
  {
    if (!empty($players)) {
     /// Output a player skill card for each player in the $players array
      foreach ($players as $player) {
        $skillCategory = Utils::escape($player["category"]);
        $skillName = Utils::escape($player["skill_name"]);
        $skillLevel = Utils::escape($player["skill_level"]);
        $comment = Utils::escape($player["comment"]);

        if($skillCategory == "Passing"){
          require("components/junior-skill.php"); ///<  Output information on a each player skill under "Passing" category
        }



      }
    } else {

      require("components/no-players-found.php"); ///< Output a message if the $players array is empty
    }
  }

  /**
   *  Only renders an array of player skills as a div card that are under the "Tackling Category"
   * 
   *  @param players - Array containing all records from the Players table.
   *  
   */

  public static function playerTacklingSkill($players)
  {
    if (!empty($players)) {
     /// Output a player skill card for each player in the $players array
      foreach ($players as $player) {
        $skillCategory = Utils::escape($player["category"]);
        $skillName = Utils::escape($player["skill_name"]);
        $skillLevel = Utils::escape($player["skill_level"]);
        $comment = Utils::escape($player["comment"]);

        if($skillCategory == "Tackling"){
          require("components/junior-skill.php");  ///<  Output information on a each player skill under "Tackling" category
        }



      }
    } else {
      require("components/no-players-found.php"); ///<  Output a message if the $players array is empty
    }
  }

  /**
   *  Only renders an array of player skills as a div card that are under the "Kicking Category"
   * 
   *  @param players - Array containing all records from the Players table.
   *  
   */

  public static function playerKickingSkill($players)
  {
    if (!empty($players)) {
      /// Output a player skill card for each player in the $players array
      foreach ($players as $player) {
        $skillCategory = Utils::escape($player["category"]);
        $skillName = Utils::escape($player["skill_name"]);
        $skillLevel = Utils::escape($player["skill_level"]);
        $comment = Utils::escape($player["comment"]);

        if($skillCategory == "Kicking"){
          require("components/junior-skill.php"); ///<  Output information on a each player skill under "Kicking" category
        }



      }
    } else {
       
      require("components/no-players-found.php"); ///<  Output a message if the $players array is empty
    }
  }

  /**
   *  Renders an array of junior positions as a div card.
   * 
   *  @param juniors - Array containing all records from the JOIN SQL command, which joins Juniors, Junior Positions and Positions tables.
   *  
   */

  public static function juniorPositions($juniors)
  {
    if (!empty($juniors)) {
      /// Output a junior positions card for each junior in the $juniors array
      foreach ($juniors as $junior) {
        $position = Utils::escape($junior["position"]);


        require("components/junior-positions.php"); ///<  Output information on a each junior position.




      }
    } else {
       
      require("components/no-players-found.php"); ///<  Output a message if the $juniors array is empty
    }
  }
  
  /**
   *  Renders an array of player positions as a div card.
   *  @param players - Array containing all records from the JOIN SQL command, which joins Players, Player Positions and Positions tables.
   *  
   */
  

  public static function playerPositions($players)
  {
    if (!empty($players)) {
      /// Output a player positions card for each player in the $players array
      foreach ($players as $player) {
        $position = Utils::escape($player["position"]);


        require("components/junior-positions.php");  ///<  Output information on a each player position.




      }
    } else {
       
      require("components/no-players-found.php"); ///<  Output a message if the $players array is empty
    }
  }

  
  /**
   *  Renders an array of members as table rows.
   * 
   *  @param members - Array containing all records from the Members table.
   *  
   */


  public static function allMembers($members)
  {
    if (!empty($members)) {
      /// Output a member card for each member in the $members array
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






        require("components/member-card.php"); ///<  Output information on a single player.
      }
    } else {
       
      require("components/no-players-found.php"); ///<  Output a message if the $players array is empty
    }
  }

  /**
   *  Renders single member record string as a individual profile page
   * 
   *  @param member - String containing single record from the Members table.
   *  
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


      require("components/member-single.php"); ///<  Output information on a single player.
    } else {
      require("components/no-single-player-found.php"); ///<  Output a message if the $players array is empty
    }
  }

  /**
   *  Renders an array of events as table rows.
   * 
   *  @param events - Array containing all event records from UNION SQL command, which unions Games and Sessions tables.
   *  
   */

  public static function allEvents($events){
    if (!empty($events)) {
      /// Output a event card for each event in the $events array
      foreach ($events as $event) {

        $type = Utils::escape($event["type"]); /// Retrieve the type of event

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



        require("components/event-card.php");  ///<  Output information on each event.
      }
    } 
  }

  /**
   *  Renders single game record string as a individual profile page.
   * 
   *  @param game - String containing single record from the Games table.
   *  
   */

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

      require("components/game-single.php");  ///<  Output information on a single game.
    }
  }

  /**
   *  Renders an array of game halves as table rows.
   * 
   *  @param gameHalves - Array containing all game halves records from the Game Halves table.
   *  
   */

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

        require("components/game-half-single.php");  ///<  Output information on each game half.

      } 
    }

  }

  /**
   *  Renders an array of training details as table rows.
   * 
   *  @param trainingDetails - Array containing all training details records from the Training Details table.
   *  
   */

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

        require("components/training-detail-single.php");  ///<  Output information on each training details.

      } 
    }

  }

  /**
   *  Renders single session record string as a individual profile page.
   * 
   *  @param session - String containing single record from the Sessions table.
   *  
   */

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






      require("components/session-single.php"); ///<  Output information on a single player

    } else {
      require("components/no-single-player-found.php"); ///< Output a message if the $players array is empty
    }
  }
}
