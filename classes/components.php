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


      // Output information on a single book
      require("components/junior-single.php");
    } else {
      // Output a message if the $books array is empty
      require("components/no-single-book-found.php");
    }
  }
}
