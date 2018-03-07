Feature: Magento Base
    As a developer
    I want to check if magento is running
    So that the test suits can continue

    Scenario: Access magento homepage
        Given a magento ecommerce
        When I access its  homepage
        Then I should see the ecommerce logo
        And a products list
