<?php

class SQL {
  public static $getAllBooks = "SELECT * FROM books";

  /**
   * Get the book with the id given in the URL parameter.
   * 
   * The ? indicates a placeholder value which we will supply 
   * when executing the statement.
   */
  public static $getBook = "SELECT * FROM books WHERE book_id = ?";
  public static $getUser = "SELECT user_id, username, password, user_role FROM users WHERE username = ?";
  public static $createUser = "INSERT INTO users (username, email, password) VALUES (?,?,?)";
  public static $getResources = "SELECT * FROM resources ORDER BY name;"
  public static $getEvents = "SELECT * FROM events WHERE NOT ((end <= :start) OR (start >= :end))')";
  public static $updateEvents = "UPDATE events SET name = :text, color = :color WHERE id = :id";
  public static $updateEvents2 = "UPDATE events SET start = :start, end = :end, resource_id = :resource WHERE id = :id)";
  public static $createEvent = "INSERT INTO events (name, start, end, resource_id) VALUES (:name, :start, :end, :resource)"


  
}