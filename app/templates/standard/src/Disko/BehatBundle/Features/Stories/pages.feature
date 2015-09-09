# language: en
# Auteur : Jerphagnon Adrien

Feature: Disponibilitée des pages

  Scenario Outline: Url are valid
      When I am on "<url>"
      Then the response status code should not be 404

        Examples:
        | url                        |
        | /                          |