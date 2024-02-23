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
  public static $getJunior = "SELECT j.*, a.*, s.category, s.skill_name, js.skill_level, js.comment
  FROM simplyrugby.juniors j 
  LEFT JOIN simplyrugby.addresses a ON j.address_id = a.address_id 
  LEFT JOIN simplyrugby.junior_skills js ON j.junior_id = js.junior_id 
  LEFT JOIN simplyrugby.skills s ON js.skill_id = s.skill_id 
  WHERE j.junior_id = ?";
   public static $getMember =   "SELECT m.*, a.* FROM simplyrugby.members m LEFT JOIN simplyrugby.addresses a ON m.address_id = a.address_id WHERE m.member_id = ?";
  public static $getBook = "SELECT p.*, a.*, d.* FROM simplyrugby.players p LEFT JOIN simplyrugby.addresses a ON p.address_id = a.address_id LEFT JOIN simplyrugby.doctors d ON p.doctor_id = d.doctor_id WHERE p.player_id = ?";
  public static $getUser = "SELECT user_id, username, password, user_role FROM users WHERE username = ?";
  public static $createUser = "INSERT INTO users (username, email, password, user_role) VALUES (?,?,?,?)";

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



  
}