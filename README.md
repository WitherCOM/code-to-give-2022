# Technology 

## Frontend
- Angular
- Bootstrap

## Backend
- Lumen (php)
### Database structure
- users (*table*)
### Controllers and endpoints
- AuthController
  - `/api/login` `POST`
  - `/api/register` `POST`
  - `/api/confirm/{token}` `GET`
- LinkController
  - `/api/link` `POST`
  - `/api/link/{id}` `GET`
  - `/api/link/{id}` `DELETE`
- CustomerController
  - `/api/customer` `POST`
  - `/api/customer[/{id}]` `GET`
  - `/api/customer/{id}` `PATCH`
  - `/api/customer/{id}` `DELETE`
- EnglishTestController
  - `/api/english_test` `POST`
  - `/api/english_test[/{id}]` `GET`
  - `/api/english_test/{id}` `PATCH`
  - `/api/english_test/{id}` `DELETE`
- EnglishFillController
  - `/api/english_answer` `POST`
  - `/api/english_answer/{id}` `GET`

# Basic concept (work flow)
- As an admin user
  - You can only register via an invitational link ( not implemented yet, anyone can register )
  - You can create,edit and delete tests ( yet only english tests)
  - You can create,edit and delete customer ( the persons who will complete the test)
  - You can create invitational links for other admin users
  - You can create link for customers to complete the tests
  - You can evaluate the tests
- As a customer
  - The admin user will add you to the customers page (optionally customers can register them self (not implemented))
  - With the link given by the admin, the customer can complete the test ( yet only the english test )

# Functional specification
- Survey style
- Page to complete the survey
- Page to edit survey

