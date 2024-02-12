<?php

class SQL {
  public static $getAllBooks = "SELECT * FROM players";

  /**
   * Get the book with the id given in the URL parameter.
   * 
   * The ? indicates a placeholder value which we will supply 
   * when executing the statement.
   */
  public static $getBook =   "SELECT p.*, a.* FROM simplyrugby.players p LEFT JOIN simplyrugby.addresses a ON p.address_id = a.address_id WHERE p.player_id = ?";
  public static $getUser = "SELECT user_id, username, password, user_role FROM users WHERE username = ?";
  public static $createUser = "INSERT INTO users (username, email, password) VALUES (?,?,?)";


  
}