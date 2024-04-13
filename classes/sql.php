<?php

/**
 * 
 * @brief This class is responsible for containing SQL commands.
 * 
 * These include:
 * - SELECT commands
 * - LEFT JOIN SELECT commands
 * - UNION SELECT commands
 * - INSERT INTO commands
 * - UPDATE commands
 * - DELETE commands
 * 
 */

class SQL {
  public static $getallPlayers = "SELECT * FROM players"; ///< Select all records from players table
  public static $getAllJuniors = "SELECT * FROM juniors"; ///< Select all records from juniors table
  public static $getAllMembers = "SELECT * FROM members"; ///< Select all records from members table
  public static $getAllDoctors = "SELECT * FROM simplyrugby.doctors"; ///< Select all records from doctors table
  public static $getAllCoaches = "SELECT * FROM simplyrugby.coaches"; ///< Select all records from coaches table

  /**
   * Gets records from left table and matches them with records from the right table.
   */

  public static $getAllGuardians = "SELECT g.*, a.*
  FROM simplyrugby.guardians g 
  LEFT JOIN simplyrugby.addresses a ON g.address_id = a.address_id"; 

  /**
   * Gets records from left table and matches them with records from the right table.
   */


  public static $getJunior = "SELECT j.*, a.*, d.*, s.category, s.skill_name, js.skill_level, js.comment
  FROM simplyrugby.juniors j 
  LEFT JOIN simplyrugby.addresses a ON j.address_id = a.address_id 
  LEFT JOIN simplyrugby.junior_skills js ON j.junior_id = js.junior_id 
  LEFT JOIN simplyrugby.skills s ON js.skill_id = s.skill_id
  LEFT JOIN simplyrugby.junior_associations ja ON j.junior_id = ja.junior_id 
  LEFT JOIN simplyrugby.doctors d ON d.doctor_id = ja.doctor_id 
  WHERE j.junior_id = ?";

  public static $getDoctor = "SELECT * FROM simplyrugby.doctors WHERE doctor_id = ?"; ///< Select one record of specific doctor
  public static $deleteDoctor = "DELETE FROM simplyrugby.doctors WHERE doctor_id = ?"; ///< Delete doctor with specific ID number


  /**
   * Gets records from left table and matches them with records from the right table.
   */

  public static $getJuniorGuardians = "SELECT j.*, g.*
  FROM simplyrugby.juniors j 
  LEFT JOIN simplyrugby.junior_associations ja ON ja.junior_id = j.junior_id
  LEFT JOIN simplyrugby.guardians g ON g.guardian_id = ja.guardian_id  
  WHERE j.junior_id = ?";

  public static $getGame = "SELECT * FROM simplyrugby.games WHERE name = ? AND start = ? AND end = ?"; ///< Get game that starts and ends at specific date.
  public static $getSession = "SELECT * FROM simplyrugby.sessions WHERE name = ? AND start = ? AND end = ?"; ///< Get training session that starts and ends at specific date.
  

  public static $getSessionId = "SELECT * FROM simplyrugby.sessions WHERE session_id = ?"; ///< Get ID number of specific Training Session


  public static $createSession = "INSERT INTO simplyrugby.sessions (coach_id, squad_id, name, start, end, location) VALUES (?, ?, ?, ?, ?, ?)";  ///< Create new training session record
  public static $getCoach  = "SELECT * FROM simplyrugby.coaches WHERE first_name = ? AND last_name = ?";  ///< Get coach with specific personal details
  public static $getCoachById = "SELECT * FROM simplyrugby.coaches WHERE coach_id = ?"; ///< Get speficic coach by his ID number

  public static $createGame = "INSERT INTO simplyrugby.games (squad_id, name, opposition_team	, start, end, location, kickoff_time, result, score) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"; ///< Create new game record

  public static $createGameHalf = "INSERT INTO simplyrugby.game_halves (game_id, half_number, home_team, opposition_team) VALUES (?, ?, ?, ?)"; ///< Create new game half record (half_number can only be 1 or 2)

  public static $getSquad = "SELECT * FROM simplyrugby.squads WHERE squad_name = ?"; ///< Get squad with specific squad name

  public static $getSquads = "SELECT * FROM simplyrugby.squads"; ///< Get all squads from the squads table


  public static $getSquadName = "SELECT squad_name FROM simplyrugby.squads WHERE squad_id = ?"; ///< Only get squad name of specific squad

  /**
   * Gets records from left table and matches them with records from the right table, if available. 
   */

  public static $getMember =   "SELECT m.*, a.* FROM simplyrugby.members m LEFT JOIN simplyrugby.addresses a ON m.address_id = a.address_id WHERE m.member_id = ?";  ///< Get member & address information of specific member
  public static $getplayer = "SELECT p.*, a.*, d.* FROM simplyrugby.players p LEFT JOIN simplyrugby.addresses a ON p.address_id = a.address_id LEFT JOIN simplyrugby.doctors d ON p.doctor_id = d.doctor_id WHERE p.player_id = ?"; ///< Get player, address & doctor information of speficic member
  public static $getUser = "SELECT user_id, username, password, user_role FROM users WHERE username = ?";  ///< Get user with speficic details (Register/Login - check if user exists)
  public static $createUser = "INSERT INTO users (username, email, password, user_role) VALUES (?,?,?,?)"; ///< Create new user record in users table (Register page)
  
  public static $updatePlayer = "UPDATE simplyrugby.players
  SET address_id = ?, doctor_id = ?, first_name = ?, last_name = ?, dob = ?, sru_no = ?, contact_no = ?, mobile_no = ?, email_address = ?, next_of_kin = ?, kin_contact_no = ?, health_issues = ?, filename = ?
  WHERE player_id = ?";  ///< Update existing player record

  public static $updateJunior = "UPDATE simplyrugby.juniors
  SET address_id = ?, first_name = ?, last_name = ?, dob = ?, sru_no = ?, contact_no = ?, mobile_no = ?, email_address = ?, health_issues = ?, filename = ?
  WHERE junior_id = ?"; ///< Update existing junior player record

  public static $updateJuniorAssociations = "UPDATE simplyrugby.junior_associations
  SET guardian_id = ?, doctor_id = ?
  WHERE junior_id = ?"; ///< Update existing junior association record

  public static $updateMember = "UPDATE simplyrugby.members
  SET address_id = ?, first_name = ?, last_name = ?, dob = ?, sru_no = ?, contact_no = ?, mobile_no = ?, email_address = ?, filename = ?
  WHERE member_id = ?"; ///< Update existing member record

  public static $updateCoach = "UPDATE simplyrugby.coaches
  SET first_name = ?, last_name = ?, dob = ?, contact_no = ?, mobile_no = ?, email_address = ?, filename = ?
  WHERE coach_id = ?"; ///< Update existing coach record

  public static $playerExists = "SELECT * FROM simplyrugby.players 
  WHERE first_name = ? AND last_name = ? AND dob = ? AND sru_no = ? AND contact_no = ? AND mobile_no = ?"; ///< Get player with specific personal details

  public static $juniorExists = "SELECT * FROM simplyrugby.juniors 
  WHERE first_name = ? AND last_name = ? AND dob = ? AND sru_no = ? AND contact_no = ? AND mobile_no = ?"; ///< Get junior with specific personal details
  

  public static $memberExists = "SELECT * FROM members
  WHERE first_name = ? AND last_name =? AND dob = ? AND sru_no = ? AND contact_no = ? AND mobile_no = ?"; ///< Get member with specific personal details
  

  public static $doctorExists = "SELECT * FROM doctors 
  WHERE doctor_first_name = ? AND doctor_last_name = ? AND doctor_contact_no = ?"; ///< Get doctor with specific personal details

  public static $guardianExists = "SELECT * FROM guardians 
  WHERE guardian_first_name = ? AND guardian_last_name = ? AND guardian_contact_no = ?"; ///< Get guardian with specific personal details

  public static $getExistingDoctorId = "SELECT doctor_id FROM doctors WHERE doctor_first_name = ? AND doctor_last_name = ? AND doctor_contact_no = ?"; ///< Only get doctor_id of doctor with specific personal details
  
  public static $getExistingAddressId = "SELECT address_id FROM addresses WHERE address_line = ? AND address_line2 = ? AND city = ? AND county = ? AND postcode = ?"; ///< Only get address_id of address with specific details

  public static $getAddress = "SELECT * FROM simplyrugby.addresses WHERE address_id = ?"; ///< Get specific address

  public static $deleteAddress = "DELETE FROM simplyrugby.addresses WHERE address_id = ?"; ///< Delete specific address record from database

  public static $addressExists = "SELECT * FROM addresses WHERE address_line = ? AND address_line2 = ? AND city = ? AND county = ? AND postcode = ?"; ///< Get address with specific details

  public static $getAllAddresses = "SELECT * FROM simplyrugby.addresses"; ///< Get all address records from addresses table

  public static $createNewAddress = "INSERT INTO simplyrugby.addresses (address_line, address_line2, city, county, postcode)
  VALUES  (?, ?, ?, ?, ?)"; ///< Create new address record

  public static $createNewDoctor = "INSERT INTO simplyrugby.doctors (doctor_first_name, doctor_last_name, doctor_contact_no)
  VALUES (?, ?, ?)"; ///< Create new doctor record

  public static $createNewGuardian = "INSERT INTO simplyrugby.guardians (address_id, guardian_first_name, guardian_last_name, guardian_contact_no, relationship)
  VALUES  (?, ?, ?, ?, ?)"; ///< Create new guardian record

  public static $createNewPlayer ="INSERT INTO simplyrugby.players (address_id, doctor_id, first_name, last_name, dob, sru_no, contact_no, mobile_no, email_address, next_of_kin, kin_contact_no, health_issues, filename)
  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"; ///< Create new player record

  public static $createNewMember ="INSERT INTO simplyrugby.members (address_id, first_name, last_name, dob, sru_no, contact_no, mobile_no, email_address, filename)
  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"; ///< Create new member record

  public static $createNewJunior = "INSERT INTO simplyrugby.juniors(address_id, first_name, last_name, dob, sru_no, contact_no, mobile_no, email_address, health_issues, filename) 
  VALUES (?,?,?,?,?,?,?,?,?,?)"; ///< Create new junior record

  /**
   * Gets records from left table and matches them with records from the right table, if available.
   */

  public static $getJuniorSkills = "SELECT j.*, s.category, s.skill_name, js.skill_level, js.comment
  FROM simplyrugby.juniors j 
  LEFT JOIN simplyrugby.junior_skills js ON j.junior_id = js.junior_id 
  LEFT JOIN simplyrugby.skills s ON js.skill_id = s.skill_id 
  WHERE j.junior_id = ?"; 

  /**
   * Gets records from left table and matches them with records from the right table, if available.
   */

  public static $getPlayerSkills = "SELECT p.*, s.skill_id, s.category, s.skill_name, ps.skill_level, ps.comment
  FROM simplyrugby.players p 
  LEFT JOIN simplyrugby.player_skills ps ON p.player_id = ps.player_id 
  LEFT JOIN simplyrugby.skills s ON ps.skill_id = s.skill_id 
  WHERE p.player_id = ?"; 
  

  public static $updateJuniorSkills = "UPDATE simplyrugby.junior_skills SET skill_level = ?, comment = ? WHERE skill_id = ? AND junior_id = ?"; ///< Update existing junior_skills record


  /**
   * Gets records from left table and matches them with records from the right table, if available.
   */

  public static $getJuniorPositions = "SELECT j.*, p.position
  FROM simplyrugby.juniors j 
  LEFT JOIN simplyrugby.junior_positions jp ON j.junior_id = jp.junior_id
  LEFT JOIN simplyrugby.positions p ON jp.position_id = p.position_id
  WHERE j.junior_id = ?";

  /**
   * Gets records from left table and matches them with records from the right table, if available.
   */


  public static $getPlayerPositions = "SELECT pl.*, p.position
  FROM simplyrugby.players pl
  LEFT JOIN simplyrugby.player_positions pp ON pl.player_id = pp.player_id
  LEFT JOIN simplyrugby.positions p ON pp.position_id = p.position_id
  WHERE pl.player_id = ?";

  public static $selectPlayer = "SELECT * FROM simplyrugby.players WHERE player_id = ?"; ///< Get player with specific ID number

  /**
   * Combines results of two or more SELECT querries into a single table.
   */

  public static $getEvents = "SELECT session_id AS id, 'session_id' AS type, name, start, end, location FROM simplyrugby.sessions 
  UNION 
  SELECT game_id AS id, 'game_id' AS type, name, start, end, location FROM simplyrugby.games";

  public static $createAssociation = "INSERT INTO simplyrugby.junior_associations(junior_id, guardian_id, doctor_id) VALUES (?,?,?)"; ///< Create new junior association record (associates junior with doctors, guardians, etcs)

  /**
   * 
   * Updates user_id field in a table.
   * 
   * The table depends on the passed table parameter.
   * %s allows for dynamic table names
   * 
   */

  public static $assignUserId = "UPDATE %s SET user_id = ? WHERE email_address = ?"; 
 
  public static $deleteJunior = "DELETE FROM juniors WHERE junior_id = ?"; ///< Delete speficic junior from database
  public static $deleteJuniorAssociation = "DELETE FROM junior_associations WHERE junior_id = ?"; ///< Delete association of specific junior from database
  public static $deleteJuniorPosition = "DELETE FROM junior_positions WHERE junior_id = ?";  ///< Delete position of specific junior from database
  public static $deleteJuniorSkill = "DELETE FROM junior_skills WHERE junior_id = ?"; ///< Delete skills of specific junior from database

  public static $deleteCoach = "DELETE FROM simplyrugby.coaches WHERE coach_id = ?"; ///< Delete coach with speficic id from database

  public static $deleteMember = "DELETE FROM members WHERE member_id = ?";  ///< Delete member with speficic id from database

  public static $deletePlayerSkill = "DELETE FROM player_skills WHERE player_id = ?";  ///< Delete skills of specific player from database
  public static $deletePlayerPosition = "DELETE FROM player_positions WHERE player_id = ?";  ///< Delete position of specific player from database
  public static $deletePlayer = "DELETE FROM players WHERE player_id = ?"; ///< Delete player with speficic id from database

  public static $getTrainingDetails = "SELECT * FROM simplyrugby.training_details WHERE session_id = ?"; ///< Get all training details for speficic training session

  public static $getSingleGame = "SELECT * FROM simplyrugby.games WHERE game_id = ?"; ///< Get game with speficic ID number

  public static $getGameHalves = "SELECT * FROM simplyrugby.game_halves WHERE game_id = ?"; ///< Get all game halves for speficic game (Only 2 halves for each game)

  public static $deleteGameHalves = "DELETE FROM simplyrugby.game_halves WHERE game_id = ?"; ///< Delete all game halves of a speficic game from database

  public static $deleteGame = "DELETE FROM simplyrugby.games WHERE game_id = ?"; ///< Delete game with speficic ID number

  public static $updateGameHalf = "UPDATE simplyrugby.game_halves SET home_team = ?, home_score = ?, home_comment = ?, opposition_team = ?, opposition_score = ?, opposition_comment = ? WHERE game_half_id = ?"; ///< Update speficic game half

  public static $updatePlayerSkill = "UPDATE simplyrugby.player_skills SET skill_level = ?, comment = ? WHERE skill_id = ? AND player_id = ?"; ///< Update specific skill of a speficic player

  public static $updateGame = "UPDATE simplyrugby.games SET squad_id = ?, name = ?, opposition_team = ?, start = ?, end = ?, location = ?, kickoff_time = ?, result = ?, score = ? WHERE game_id = ?"; ///< Update specific game

  public static $deleteSession = "DELETE FROM simplyrugby.sessions WHERE session_id = ?"; ///< Delete speficic training session

  public static $deleteTrainingDetails = "DELETE FROM simplyrugby.training_details WHERE session_id = ?"; ///< Delete training details of a specific training session


  public static $createTrainingDetails = "INSERT INTO simplyrugby.training_details(session_id,	coach_id,	squad_id) VALUES (?,	?,	?)"; ///< Create new training details record

  public static $updateSession = "UPDATE simplyrugby.sessions SET coach_id = ?, squad_id = ?, name = ?, start = ?, end = ?, location = ? WHERE session_id = ?"; ///< Update specific training session

  public static $updateTrainingDetails = "UPDATE simplyrugby.training_details SET coach_id = ?, squad_id = ?, skills = ?, activities = ?, present_players = ?, accidents = ?, injuries = ? WHERE training_details_id = ?"; ///< Update specific training details

  /**
   * 
   * Retrieves guardian information based on junior_id from junior_associations
   * 
   * I feel like this might be redundant, this will be investigated in future updates
   * 
   */

  public static $getGuardian = "SELECT
  g.guardian_id,
  g.guardian_first_name,
  g.guardian_last_name,
  g.guardian_contact_no,
  g.relationship
FROM
  simplyrugby.guardians g
LEFT JOIN
  simplyrugby.junior_associations ja ON g.guardian_id = ja.guardian_id
  WHERE ja.junior_id = ?"; 


  /**
   * 
   * Retrieves guardian and address information based on guardian_id
   * 
   * Hmm... This might also be reduntant. I shall investigate this in future updates.
   * 
   * 
   */
  public static $getGuardianAddress = "SELECT
  a.address_line,
  a.address_line2,
  a.city,
  a.county,
  a.postcode
FROM
  simplyrugby.guardians g
LEFT JOIN
  simplyrugby.addresses a ON g.address_id = a.address_id
WHERE g.guardian_id = ?";

public static $getGuardianById = "SELECT * FROM simplyrugby.guardians WHERE guardian_id = ?"; ///< Get specific guardian

public static $deleteGuardian = "DELETE * FROM simplyrugby.guardians WHERE guardian_id = ?"; ///< Delete specific guardian (only works if guardian isn't present in other tables)
}