<?php

class SQL {
  public static $getAllBooks = "SELECT * FROM players";
  public static $getAllJuniors = "SELECT * FROM juniors";
  public static $getAllMembers = "SELECT * FROM members";
  /**
   * Get the book with the id given in the URL parameter.
   * 
   * The ? indicates a placeholder value which we will supply 
   * when executing the statement.
   */
  public static $getJunior = "SELECT j.*, a.*, d.*, s.category, s.skill_name, js.skill_level, js.comment
  FROM simplyrugby.juniors j 
  LEFT JOIN simplyrugby.addresses a ON j.address_id = a.address_id 
  LEFT JOIN simplyrugby.junior_skills js ON j.junior_id = js.junior_id 
  LEFT JOIN simplyrugby.skills s ON js.skill_id = s.skill_id
  LEFT JOIN simplyrugby.junior_associations ja ON j.junior_id = ja.junior_id 
  LEFT JOIN simplyrugby.doctors d ON d.doctor_id = ja.doctor_id 
  WHERE j.junior_id = ?";

  public static $getJuniorGuardians = "SELECT j.*, g.*
  FROM simplyrugby.juniors j 
  LEFT JOIN simplyrugby.junior_associations ja ON ja.junior_id = j.junior_id
  LEFT JOIN simplyrugby.guardians g ON g.guardian_id = ja.guardian_id  
  WHERE j.junior_id = ?";

  public static $getGame = "SELECT * FROM simplyrugby.games WHERE name = ? AND start = ? AND end = ?";
  public static $getSession = "SELECT * FROM simplyrugby.sessions WHERE name = ? AND start = ? AND end = ?";
  
  public static $createSession = "INSERT INTO simplyrugby.sessions (coach_id, squad_id, name, start, end, location) VALUES (?, ?, ?, ?, ?, ?)";
  public static $getCoach  = "SELECT * FROM simplyrugby.coaches WHERE first_name = ? AND last_name = ?";

  public static $createGame = "INSERT INTO simplyrugby.games (squad_id, name, opposition_team	, start, end, location, kickoff_time, result, score) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

  public static $createGameHalf = "INSERT INTO simplyrugby.game_halves (game_id, half_number, home_team, opposition_team) VALUES (?, ?, ?, ?)";

  public static $getSquad = "SELECT * FROM simplyrugby.squads WHERE squad_id = ?";

  public static $getSquadName = "SELECT squad_name FROM simplyrugby.squads WHERE squad_id = ?";

  public static $getMember =   "SELECT m.*, a.* FROM simplyrugby.members m LEFT JOIN simplyrugby.addresses a ON m.address_id = a.address_id WHERE m.member_id = ?";
  public static $getBook = "SELECT p.*, a.*, d.* FROM simplyrugby.players p LEFT JOIN simplyrugby.addresses a ON p.address_id = a.address_id LEFT JOIN simplyrugby.doctors d ON p.doctor_id = d.doctor_id WHERE p.player_id = ?";
  public static $getUser = "SELECT user_id, username, password, user_role FROM users WHERE username = ?";
  public static $createUser = "INSERT INTO users (username, email, password, user_role) VALUES (?,?,?,?)";
  public static $updatePlayer = "UPDATE simplyrugby.players
  SET address_id = ?, doctor_id = ?, first_name = ?, last_name = ?, dob = ?, sru_no = ?, contact_no = ?, mobile_no = ?, email_address = ?, next_of_kin = ?, kin_contact_no = ?, health_issues = ?, filename = ?
  WHERE player_id = ?";

  public static $updateJunior = "UPDATE simplyrugby.juniors
  SET address_id = ?, first_name = ?, last_name = ?, dob = ?, sru_no = ?, contact_no = ?, mobile_no = ?, email_address = ?, health_issues = ?, filename = ?
  WHERE junior_id = ?";

  public static $updateJuniorAssociations = "UPDATE simplyrugby.junior_associations
  SET guardian_id = ?, doctor_id = ?
  WHERE junior_id = ?";

  public static $updateMember = "UPDATE simplyrugby.members
  SET address_id = ?, first_name = ?, last_name = ?, dob = ?, sru_no = ?, contact_no = ?, mobile_no = ?, email_address = ?, filename = ?
  WHERE member_id = ?";

  public static $playerExists = "SELECT * FROM simplyrugby.players 
  WHERE first_name = ? AND last_name = ? AND dob = ? AND sru_no = ? AND contact_no = ? AND mobile_no = ?";

  public static $juniorExists = "SELECT * FROM simplyrugby.juniors 
  WHERE first_name = ? AND last_name = ? AND dob = ? AND sru_no = ? AND contact_no = ? AND mobile_no = ?";
  

  public static $memberExists = "SELECT * FROM members
  WHERE first_name = ? AND last_name =? AND dob = ? AND sru_no = ? AND contact_no = ? AND mobile_no = ?";
  

  public static $addressExists = "SELECT * FROM addresses 
  WHERE address_line = ? AND address_line2 = ? AND city = ? AND county = ? AND postcode = ?";
  
  public static $doctorExists = "SELECT * FROM doctors 
  WHERE doctor_first_name = ? AND doctor_last_name = ? AND doctor_contact_no = ?";

  public static $guardianExists = "SELECT * FROM guardians 
  WHERE guardian_first_name = ? AND guardian_last_name = ? AND guardian_contact_no = ?";

  public static $getExistingDoctorId = "SELECT doctor_id 
  FROM doctors 
  WHERE doctor_first_name = ? 
  AND doctor_last_name = ? 
  AND doctor_contact_no = ?";
  
  public static $getExistingAddressId = "SELECT address_id 
  FROM addresses 
  WHERE address_line = ? 
  AND address_line2 = ? 
  AND city = ? 
  AND county = ? 
  AND postcode = ?";

  public static $createNewAddress = "INSERT INTO simplyrugby.addresses (address_line, address_line2, city, county, postcode)
  VALUES  (?, ?, ?, ?, ?)";

  public static $createNewDoctor = "INSERT INTO simplyrugby.doctors (doctor_first_name, doctor_last_name, doctor_contact_no)
  VALUES (?, ?, ?)";

  public static $createNewGuardian = "INSERT INTO simplyrugby.guardians (address_id, guardian_first_name, guardian_last_name, guardian_contact_no, relationship)
  VALUES  (?, ?, ?, ?, ?)";

  public static $createNewPlayer ="INSERT INTO simplyrugby.players (address_id, doctor_id, first_name, last_name, dob, sru_no, contact_no, mobile_no, email_address, next_of_kin, kin_contact_no, health_issues, filename)
  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

  public static $createNewMember ="INSERT INTO simplyrugby.members (address_id, first_name, last_name, dob, sru_no, contact_no, mobile_no, email_address, filename)
  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

  public static $createNewJunior = "INSERT INTO simplyrugby.juniors(address_id, first_name, last_name, dob, sru_no, contact_no, mobile_no, email_address, health_issues, filename) 
  VALUES (?,?,?,?,?,?,?,?,?,?)";

  public static $getJuniorSkills = "SELECT j.*, s.category, s.skill_name, js.skill_level, js.comment
  FROM simplyrugby.juniors j 
  LEFT JOIN simplyrugby.junior_skills js ON j.junior_id = js.junior_id 
  LEFT JOIN simplyrugby.skills s ON js.skill_id = s.skill_id 
  WHERE j.junior_id = ?";

  public static $getPlayerSkills = "SELECT p.*, s.category, s.skill_name, ps.skill_level, ps.comment
  FROM simplyrugby.players p 
  LEFT JOIN simplyrugby.player_skills ps ON p.player_id = ps.player_id 
  LEFT JOIN simplyrugby.skills s ON ps.skill_id = s.skill_id 
  WHERE p.player_id = ?";

  public static $getJuniorPositions = "SELECT j.*, p.position
  FROM simplyrugby.juniors j 
  LEFT JOIN simplyrugby.junior_positions jp ON j.junior_id = jp.junior_id
  LEFT JOIN simplyrugby.positions p ON jp.position_id = p.position_id
  WHERE j.junior_id = ?";

  public static $getPlayerPositions = "SELECT pl.*, p.position
  FROM simplyrugby.players pl
  LEFT JOIN simplyrugby.player_positions pp ON pl.player_id = pp.player_id
  LEFT JOIN simplyrugby.positions p ON pp.position_id = p.position_id
  WHERE pl.player_id = ?";

  public static $getEvents = "SELECT session_id AS id, 'session_id' AS type, name, start, end, location FROM simplyrugby.sessions 
  UNION 
  SELECT game_id AS id, 'game_id' AS type, name, start, end, location FROM simplyrugby.games;
  ";

  public static $createAssociation = "INSERT INTO simplyrugby.junior_associations(junior_id, guardian_id, doctor_id) VALUES (?,?,?)";

  public static $assignUserId = "UPDATE %s SET user_id = ? WHERE email_address = ?";

  public static $deleteJunior = "DELETE FROM juniors WHERE junior_id = ?";
  public static $deleteJuniorAssociation = "DELETE FROM junior_associations WHERE junior_id = ?";
  public static $deleteJuniorPosition = "DELETE FROM junior_positions WHERE junior_id = ?";
  public static $deleteJuniorSkill = "DELETE FROM junior_skills WHERE junior_id = ?";

  public static $deleteMember = "DELETE FROM members WHERE member_id = ?";

  public static $deletePlayerSkill = "DELETE FROM player_skills WHERE player_id = ?";
  public static $deletePlayerPosition = "DELETE FROM player_positions WHERE player_id = ?";
  public static $deletePlayer = "DELETE FROM players WHERE player_id = ?";


  public static $getSingleGame = "SELECT * FROM simplyrugby.games WHERE game_id = ?";

  public static $getGameHalves = "SELECT * FROM simplyrugby.game_halves WHERE game_id = ?";

  public static $deleteGameHalves = "DELETE FROM simplyrugby.game_halves WHERE game_id = ?";

  public static $deleteGame = "DELETE FROM simplyrugby.games WHERE game_id = ?";

}