Feature: Contacts

  Scenario: I create a contact person
    Given a clean setup
    When I go to "/"
    And I follow "Kontaktpersoner"
    And I follow "skapa ny"
    And I fill in the following:
        | name    | Foo Bar        |
        | account | 33001701172395 |
        | mail    | foo@bar.se     |
    And I press "Spara kontaktperson"
    Then I should see "Foo Bar skapades"

  Scenario: I delete a contact person
    Given a clean setup
    And contact persons:
        | ID | Foo Bar | 33001701172395 | foo@bar.se |
    When I go to "/"
    And I follow "Kontaktpersoner"
    And I follow "Foo Bar"
    And I press "radera kontaktperson"
    Then I should see "Foo Bar raderades"

  Scenario: I update a contact person
    Given a clean setup
    And contact persons:
        | ID | Foo Bar | 33001701172395 | foo@bar.se |
    When I go to "/"
    And I follow "Kontaktpersoner"
    And I follow "Foo Bar"
    And I follow "redigera"
    And I fill in the following:
        | name | BAZ |
    And I press "Spara kontaktperson"
    Then I should see "Ändringar sparades"
    And I should see "BAZ"
