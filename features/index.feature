Feature: Index

  Scenario: I load the index page
    Given a clean setup
    When I go to "/"
    Then the response status code should be 200
