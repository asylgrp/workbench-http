Feature: Error

  Scenario: I get a page not found error when browsing to unknown page
    Given a clean setup
    When I go to "/page-does-not-exist"
    Then the response status code should be 404
