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
   * Renders an array of book arrays as a gallery.
   */
  public static function allBooks($books)
  {
    if (!empty($books)) {
      // Output a book card for each book in the $books array
      foreach ($books as $book) {
        $player_id = Utils::escape($book["player_id"]);
        $address_id = Utils::escape($book["address_id"]);
        $user_id = Utils::escape($book["user_id"]);
        $doctor_id = Utils::escape($book["doctor_id"]);
        $firstName = Utils::escape($book["first_name"]);
        $lastName = Utils::escape($book["last_name"]);
        $dob = Utils::escape($book["dob"]);
        $sruNumber = Utils::escape($book["sru_no"]);
        $contactNumber = Utils::escape($book["contact_no"]);
        $mobileNumber = Utils::escape($book["mobile_no"]);
        $emailAddress = Utils::escape($book["email_address"]);
        $nextOfKin = Utils::escape($book["next_of_kin"]);
        $kinContactNumber = Utils::escape($book["kin_contact_no"]);
        $healthIssues = Utils::escape($book["health_issues"]);
        $filename = Utils::escape($book["filename"]);


        require("components/book-card.php");
      }
    } else {
      // Output a message if the $books array is empty
      require("components/no-books-found.php");
    }
  }

  /**
   * Renders a book array to the page.
   */
  public static function singleBook($book)
  {
    if (!empty($book)) {
      $player_id = Utils::escape($book["player_id"]);
      $address_id = Utils::escape($book["address_id"]);
      $dob = Utils::escape($book["dob"]);
      $user_id = Utils::escape($book["user_id"]);
      $doctor_id = Utils::escape($book["doctor_id"]);
      $firstName = Utils::escape($book["first_name"]);
      $lastName = Utils::escape($book["last_name"]);
      $sruNumber = Utils::escape($book["sru_no"]);
      $contactNumber = Utils::escape($book["contact_no"]);
      $mobileNumber = Utils::escape($book["mobile_no"]);
      $emailAddress = Utils::escape($book["email_address"]);
      $healthIssues = Utils::escape($book["health_issues"]);
      $filename = Utils::escape($book["filename"]);
      $nextOfKin = Utils::escape($book["next_of_kin"]);
      $kinContactNumber = Utils::escape($book["kin_contact_no"]);
      $address1 = Utils::escape($book["address_line"]);
      $address2 = Utils::escape($book["address_line2"]);
      $city = Utils::escape($book["city"]);
      $county = Utils::escape($book["county"]);
      $postcode = Utils::escape($book["postcode"]);
      $doctorFirstName = Utils::escape($book["doctor_first_name"]);
      $doctorLastName = Utils::escape($book["doctor_last_name"]);
      $doctorContact = Utils::escape($book["doctor_contact_no"]);

      // Output information on a single book
      require("components/book-single.php");
    } else {
      // Output a message if the $books array is empty
      require("components/no-single-book-found.php");
    }
  }

  public static function allJuniors($juniors)
  {
    if (!empty($juniors)) {
      // Output a book card for each book in the $books array
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
      // Output a message if the $books array is empty
      require("components/no-books-found.php");
    }
  }

    /**
   * Renders a book array to the page.
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


      // Output information on a single book
      require("components/junior-single.php");
    } else {
      // Output a message if the $books array is empty
      require("components/no-single-book-found.php");
    }
  }

  public static function juniorGuardians($juniors)
  {
    if (!empty($juniors)) {
      // Output a book card for each book in the $books array
      foreach ($juniors as $junior) {
        $guardianFirstName = Utils::escape($junior["guardian_first_name"]);
        $guardianLastName = Utils::escape($junior["guardian_last_name"]);
        $guardianContactNum = Utils::escape($junior["guardian_contact_no"]);
        $relationship = Utils::escape($junior["relationship"]);

        require("components/guardian-single.php");




      }
    } else {
      // Output a message if the $books array is empty
      require("components/no-books-found.php");
    }
  }

  public static function juniorPassingSkill($juniors)
  {
    if (!empty($juniors)) {
      // Output a book card for each book in the $books array
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
      // Output a message if the $books array is empty
      require("components/no-books-found.php");
    }
  }

  public static function juniorTacklingSkill($juniors)
  {
    if (!empty($juniors)) {
      // Output a book card for each book in the $books array
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
      // Output a message if the $books array is empty
      require("components/no-books-found.php");
    }
  }

  public static function juniorKickingSkill($juniors)
  {
    if (!empty($juniors)) {
      // Output a book card for each book in the $books array
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
      // Output a message if the $books array is empty
      require("components/no-books-found.php");
    }
  }

  public static function playerPassingSkill($books)
  {
    if (!empty($books)) {
      // Output a book card for each book in the $books array
      foreach ($books as $book) {
        $skillCategory = Utils::escape($book["category"]);
        $skillName = Utils::escape($book["skill_name"]);
        $skillLevel = Utils::escape($book["skill_level"]);
        $comment = Utils::escape($book["comment"]);

        if($skillCategory == "Passing"){
          require("components/junior-skill.php");
        }



      }
    } else {
      // Output a message if the $books array is empty
      require("components/no-books-found.php");
    }
  }

  public static function playerTacklingSkill($books)
  {
    if (!empty($books)) {
      // Output a book card for each book in the $books array
      foreach ($books as $book) {
        $skillCategory = Utils::escape($book["category"]);
        $skillName = Utils::escape($book["skill_name"]);
        $skillLevel = Utils::escape($book["skill_level"]);
        $comment = Utils::escape($book["comment"]);

        if($skillCategory == "Tackling"){
          require("components/junior-skill.php");
        }



      }
    } else {
      // Output a message if the $books array is empty
      require("components/no-books-found.php");
    }
  }

  public static function playerKickingSkill($books)
  {
    if (!empty($books)) {
      // Output a book card for each book in the $books array
      foreach ($books as $book) {
        $skillCategory = Utils::escape($book["category"]);
        $skillName = Utils::escape($book["skill_name"]);
        $skillLevel = Utils::escape($book["skill_level"]);
        $comment = Utils::escape($book["comment"]);

        if($skillCategory == "Kicking"){
          require("components/junior-skill.php");
        }



      }
    } else {
      // Output a message if the $books array is empty
      require("components/no-books-found.php");
    }
  }

  public static function juniorPositions($juniors)
  {
    if (!empty($juniors)) {
      // Output a book card for each book in the $books array
      foreach ($juniors as $junior) {
        $position = Utils::escape($junior["position"]);


        require("components/junior-positions.php");




      }
    } else {
      // Output a message if the $books array is empty
      require("components/no-books-found.php");
    }
  }

  public static function playerPositions($books)
  {
    if (!empty($books)) {
      // Output a book card for each book in the $books array
      foreach ($books as $book) {
        $position = Utils::escape($book["position"]);


        require("components/junior-positions.php");




      }
    } else {
      // Output a message if the $books array is empty
      require("components/no-books-found.php");
    }
  }



  public static function allMembers($members)
  {
    if (!empty($members)) {
      // Output a book card for each book in the $books array
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
      // Output a message if the $books array is empty
      require("components/no-books-found.php");
    }
  }

  /**
   * Renders a book array to the page.
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


      // Output information on a single book
      require("components/member-single.php");
    } else {
      // Output a message if the $books array is empty
      require("components/no-single-book-found.php");
    }
  }

  public static function allEvents($events){
    if (!empty($events)) {
      // Output a book card for each book in the $books array
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
    } else {
      // Output a message if the $books array is empty
      require("components/no-books-found.php");
    }
  }

  public static function singleGame($game)
  {
    if (!empty($game)) {
      $squadId = Utils::escape($game["squad_id"]);
      $gameName = Utils::escape($game["name"]);
      $oppositionName = Utils::escape($game["opposition_team"]);
      $gameStart = Utils::escape($game["start"]);
      $gameEnd = Utils::escape($game["end"]);
      $gameLocation = Utils::escape($game["location"]);
      $gameKickoff = Utils::escape($game["kickoff_time"]);
      $gameResult = Utils::escape($game["result"]);
      $gameScore = Utils::escape($game["score"]);





      // Output information on a single book
      require("components/game-single.php");
    } else {
      // Output a message if the $books array is empty
      require("components/no-single-book-found.php");
    }
  }
}
