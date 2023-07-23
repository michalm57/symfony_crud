-- Host: database:5432
-- Generation Time: Jul 23, 2023 at 08:44 AM
-- Server version: 13.4
-- PHP Version: 8.1.17

-- Database: symfony_crud

-- --------------------------------------------------------

--
-- Table structure for table contacts
--

CREATE TABLE contacts (
  id SERIAL PRIMARY KEY,
  firstname VARCHAR(255) NOT NULL,
  lastname VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

--
-- Indexes for table contacts
--

CREATE UNIQUE INDEX contacts_email_index ON contacts (email);