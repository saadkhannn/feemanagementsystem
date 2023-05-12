/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.7.33 : Database - edufee
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `course_fees` */

DROP TABLE IF EXISTS `course_fees`;

CREATE TABLE `course_fees` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` bigint(20) unsigned NOT NULL,
  `date` date NOT NULL,
  `fee` double NOT NULL DEFAULT '0',
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `course_fees_course_id_foreign` (`course_id`),
  CONSTRAINT `course_fees_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `course_fees` */

insert  into `course_fees`(`id`,`course_id`,`date`,`fee`,`description`,`created_at`,`updated_at`) values (2,1,'2023-05-09',1500,NULL,'2023-05-09 12:41:45','2023-05-09 12:43:57'),(3,2,'2023-05-09',2000,NULL,'2023-05-09 12:41:53','2023-05-09 12:41:53');

/*Table structure for table `courses` */

DROP TABLE IF EXISTS `courses`;

CREATE TABLE `courses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `courses` */

insert  into `courses`(`id`,`code`,`name`,`description`,`status`,`created_at`,`updated_at`) values (1,'CSE 101','CSE 101',NULL,1,'2023-05-07 17:46:29','2023-05-08 15:32:59'),(2,'CSE 102','CSE 102',NULL,1,'2023-05-08 15:32:54','2023-05-08 15:32:54');

/*Table structure for table `departments` */

DROP TABLE IF EXISTS `departments`;

CREATE TABLE `departments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `departments` */

insert  into `departments`(`id`,`code`,`name`,`description`,`status`,`created_at`,`updated_at`) values (2,'CSE','Computer Science & Engineering',NULL,1,'2023-05-07 17:44:26','2023-05-07 17:44:26');

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `freelinks` */

DROP TABLE IF EXISTS `freelinks`;

CREATE TABLE `freelinks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `route` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` text COLLATE utf8mb4_unicode_ci,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `freelinks` */

insert  into `freelinks`(`id`,`name`,`route`,`desc`,`status`,`created_at`,`updated_at`) values (1,'Home Page','/',NULL,1,'2020-05-17 16:11:46','2020-05-17 16:11:46'),(2,'Dashboard','dashboard',NULL,1,'2020-05-17 16:11:57','2020-05-17 16:11:57'),(3,'Login','login',NULL,1,'2020-05-17 16:12:29','2020-05-17 16:12:29'),(4,'Logout','logout',NULL,1,'2020-05-21 11:02:07','2020-05-21 11:02:07'),(5,'Change Password','peoples/change-password',NULL,1,'2020-05-23 07:35:50','2020-05-23 08:01:50'),(6,'Side Bar','side-bar',NULL,1,'2020-05-27 11:02:01','2020-05-27 11:02:01'),(7,'Backdated Check In Out','dashboard/backdated-check-in-out',NULL,1,'2020-07-19 15:40:25','2020-07-19 15:40:25');

/*Table structure for table `menu` */

DROP TABLE IF EXISTS `menu`;

CREATE TABLE `menu` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `route` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` text COLLATE utf8mb4_unicode_ci,
  `desc` text COLLATE utf8mb4_unicode_ci,
  `serial` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_module_id_foreign` (`module_id`),
  CONSTRAINT `menu_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `menu` */

insert  into `menu`(`id`,`module_id`,`name`,`route`,`icon`,`desc`,`serial`,`status`,`created_at`,`updated_at`) values (8,6,'System Settings','#','fas fa-chart-pie',NULL,1,1,'2020-05-15 13:45:58','2022-12-08 14:03:52'),(10,6,'Role Management','#','fab fa-pied-piper-alt',NULL,2,1,'2020-05-15 17:37:59','2022-12-08 14:03:44'),(53,6,'System Information','system-information','fa fa-home',NULL,0,1,'2022-12-08 14:04:16','2022-12-08 14:04:16'),(78,6,'Users','users','fa fa-users',NULL,100,1,'2023-05-07 12:55:56','2023-05-07 14:31:56'),(79,6,'Academic Settings','#','fa fa-cogs',NULL,3,1,'2023-05-07 14:32:35','2023-05-07 14:32:35'),(80,22,'Course Fees','course-fees',NULL,NULL,1,1,'2023-05-07 14:34:40','2023-05-07 14:34:40'),(81,22,'Fee Collection','fee-collections',NULL,NULL,3,1,'2023-05-07 14:34:57','2023-05-09 12:48:24'),(82,22,'Student Courses','user-courses','fa fa-tasks',NULL,0,1,'2023-05-08 15:00:03','2023-05-08 15:00:03'),(83,22,'Student Bills','user-bills','fa fa-money-check-alt',NULL,2,1,'2023-05-09 12:48:57','2023-05-09 12:48:57'),(84,22,'Notifications','notifications','fas fa-bell',NULL,4,1,'2023-05-10 15:32:27','2023-05-10 15:32:27');

/*Table structure for table `menu_permissions` */

DROP TABLE IF EXISTS `menu_permissions`;

CREATE TABLE `menu_permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` bigint(20) unsigned NOT NULL,
  `permission_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_permissions_menu_id_foreign` (`menu_id`),
  KEY `menu_permissions_permission_id_foreign` (`permission_id`),
  CONSTRAINT `menu_permissions_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `menu_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1288 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `menu_permissions` */

insert  into `menu_permissions`(`id`,`menu_id`,`permission_id`,`created_at`,`updated_at`) values (155,53,3863,NULL,NULL),(156,53,3864,NULL,NULL),(157,53,3865,NULL,NULL),(158,53,3866,NULL,NULL),(891,8,3903,NULL,NULL),(892,8,3904,NULL,NULL),(893,8,3905,NULL,NULL),(894,8,3906,NULL,NULL),(895,8,3907,NULL,NULL),(896,8,3908,NULL,NULL),(897,8,3909,NULL,NULL),(898,8,3910,NULL,NULL),(899,8,3911,NULL,NULL),(900,8,3912,NULL,NULL),(901,8,3913,NULL,NULL),(902,8,3914,NULL,NULL),(903,10,3915,NULL,NULL),(904,10,3916,NULL,NULL),(905,10,3917,NULL,NULL),(906,10,3918,NULL,NULL),(907,10,3919,NULL,NULL),(908,10,3920,NULL,NULL),(909,10,3921,NULL,NULL),(910,10,3922,NULL,NULL),(911,10,4247,NULL,NULL),(912,10,4248,NULL,NULL),(913,10,4249,NULL,NULL),(914,10,4250,NULL,NULL),(1251,10,4267,'2023-05-07 12:54:55','2023-05-07 12:54:55'),(1252,10,4268,'2023-05-07 12:54:55','2023-05-07 12:54:55'),(1253,10,4269,'2023-05-07 12:54:55','2023-05-07 12:54:55'),(1254,10,4270,'2023-05-07 12:54:55','2023-05-07 12:54:55'),(1258,78,4267,'2023-05-07 12:56:05','2023-05-07 12:56:05'),(1259,78,4268,'2023-05-07 12:56:05','2023-05-07 12:56:05'),(1260,78,4269,'2023-05-07 12:56:05','2023-05-07 12:56:05'),(1261,78,4270,'2023-05-07 12:56:05','2023-05-07 12:56:05'),(1262,79,4274,'2023-05-07 14:38:43','2023-05-07 14:38:43'),(1263,79,4275,'2023-05-07 14:38:43','2023-05-07 14:38:43'),(1264,79,4276,'2023-05-07 14:38:43','2023-05-07 14:38:43'),(1265,79,4277,'2023-05-07 14:38:43','2023-05-07 14:38:43'),(1266,79,4278,'2023-05-07 14:38:43','2023-05-07 14:38:43'),(1267,79,4279,'2023-05-07 14:38:43','2023-05-07 14:38:43'),(1268,79,4280,'2023-05-07 14:38:43','2023-05-07 14:38:43'),(1269,79,4281,'2023-05-07 14:38:43','2023-05-07 14:38:43'),(1274,81,4286,'2023-05-07 14:39:12','2023-05-07 14:39:12'),(1275,81,4287,'2023-05-07 14:39:12','2023-05-07 14:39:12'),(1276,81,4288,'2023-05-07 14:39:12','2023-05-07 14:39:12'),(1277,82,4289,'2023-05-08 15:00:03','2023-05-08 15:00:03'),(1278,82,4290,'2023-05-08 15:00:03','2023-05-08 15:00:03'),(1279,80,4291,'2023-05-09 12:27:25','2023-05-09 12:27:25'),(1280,80,4292,'2023-05-09 12:27:25','2023-05-09 12:27:25'),(1281,80,4293,'2023-05-09 12:27:25','2023-05-09 12:27:25'),(1282,80,4294,'2023-05-09 12:27:25','2023-05-09 12:27:25'),(1283,83,4295,'2023-05-09 12:50:43','2023-05-09 12:50:43'),(1284,83,4296,'2023-05-09 12:50:43','2023-05-09 12:50:43'),(1285,83,4297,'2023-05-09 12:50:43','2023-05-09 12:50:43'),(1286,83,4298,'2023-05-09 12:50:43','2023-05-09 12:50:43'),(1287,84,4299,'2023-05-10 15:32:27','2023-05-10 15:32:27');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1061 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2020_05_14_184001_roles',1),(6,'2020_05_15_093124_modules',1),(7,'2020_05_15_093132_menu',1),(8,'2020_05_15_093136_submenu',1),(9,'2020_05_15_093142_options',1),(10,'2020_05_15_095045_firstforeignkeys',1),(11,'2020_05_17_160043_freelinks',1),(12,'2020_05_17_164259_employees',1),(13,'2020_05_17_170924_designations',1),(14,'2020_05_17_170932_functions',1),(15,'2020_05_17_170938_subfunctions',1),(16,'2020_05_17_171043_joblevels',1),(17,'2020_05_17_171048_joblocations',1),(18,'2020_05_17_171102_teams',1),(19,'2020_05_17_171112_employee_categories',1),(20,'2020_05_17_171126_brands',1),(21,'2020_05_17_171135_legal_entitiess',1),(22,'2020_05_17_171144_religions',1),(23,'2020_05_17_171201_separation_options',1),(24,'2020_05_17_171209_trustee_boards',1),(25,'2020_05_17_171214_trustee_board_members',1),(26,'2020_05_17_172607_employee_details',1),(27,'2020_05_17_174712_countries',1),(28,'2020_05_17_175951_employee_logs',1),(29,'2020_05_17_180206_employee_foreignkeys',1),(30,'2020_05_20_140543_shifts',1),(31,'2020_05_20_140855_employeeshifts',1),(32,'2020_05_20_140910_employee_first_foreignkeys',1),(33,'2020_05_22_163952_employee_childs',1),(34,'2020_05_22_163959_employee_educations',1),(35,'2020_05_22_164058_EmployeeSecondforeign_keys',1),(36,'2020_05_28_114753_holiday_types',1),(37,'2020_05_28_114759_holidays',1),(38,'2020_05_28_115304_Secondforeignkeys',1),(39,'2020_05_28_115454_leave_types',1),(40,'2020_05_28_141811_leaves',1),(41,'2020_05_28_141826_leave_foreign_keys',1),(42,'2020_07_15_141637_devices',1),(43,'2020_07_15_141645_checkinouts',1),(44,'2020_07_18_151601_attendances',1),(45,'2020_07_18_151923_Attendance_foreign_keys',1),(46,'2020_07_19_095809_on_special_duties',1),(47,'2020_07_19_095822_working_from_home',1),(48,'2020_07_19_100308_Attendance_foreign_keys_stage_2',1),(49,'2020_07_19_123705_remote_attendance',1),(50,'2020_07_20_160012_ot_applications',1),(51,'2020_07_20_160024_overtime_foreign_keys',1),(52,'2020_07_22_135547_issues',1),(53,'2020_07_22_135602_solutions',1),(54,'2020_07_22_135906_topics',1),(55,'2020_07_22_140142_issue_foreign_keys',1),(56,'2020_07_23_100645_provident_fund_settings',1),(57,'2020_07_23_100655_loan_settings',1),(58,'2020_07_23_110955_loan_types',1),(59,'2020_07_23_111006_foreign_keys_last_stage',1),(60,'2020_07_23_120522_provident_fund',1),(61,'2020_07_23_120534_loans',1),(62,'2020_07_23_120602_loan_installements',1),(63,'2020_07_23_120641_payroll_first_foreign_keys',1),(64,'2020_07_26_070137_salary_heads',1),(65,'2020_07_26_070151_attendance_based_salary_heads',1),(66,'2020_07_26_070256_employee_salaries',1),(67,'2020_07_26_070308_employee_salary_heads',1),(68,'2020_07_26_070326_EmployeeThirdforeign_keyes',1),(69,'2020_07_26_070357_taxes',1),(70,'2020_07_26_070403_tax_rules',1),(71,'2020_07_26_070413_third_foreign_keys',1),(72,'2020_08_08_124701_monthly_payrolls',1),(73,'2020_08_08_124712_monthly_payroll_heads',1),(74,'2020_08_08_124720_monthly_payroll_attendance_based_heads',1),(75,'2020_08_08_124738_monthly_payroll_foreign_keys',1),(76,'2020_08_08_133557_weekly_payroll',1),(77,'2020_08_08_133602_weekly_payroll_foreign_keys',1),(78,'2020_08_09_125158_salary_head_details',1),(79,'2020_08_09_125209_attendance_baesd_salary_head_details',1),(80,'2020_08_09_125222_foreign_key_latest_stage',1),(81,'2020_08_22_140133_publishment_types',1),(82,'2020_08_22_140313_publishments',1),(83,'2020_08_22_140320_publishment_foreign_keys',1),(84,'2022_08_23_142728_payroll_new_keys',1),(85,'2022_08_23_150158_update_users',1),(87,'2022_12_08_085841_system_information',2),(89,'2022_12_11_052219_portfolios',4),(90,'2022_12_11_052226_programs',4),(91,'2022_12_11_052317_project_types',4),(92,'2022_12_11_052342_objectives',4),(93,'2022_12_11_052451_program_project_types',4),(94,'2022_12_11_052618_projects',4),(95,'2022_12_11_052626_project_boards',4),(96,'2022_12_11_052638_project_departments',4),(97,'2022_12_11_052836_project_scopes',4),(98,'2022_12_11_052856_project_objectives',4),(99,'2022_12_11_052910_project_phases',4),(100,'2022_12_11_052917_project_milestones',4),(101,'2022_12_11_052925_project_tasks',4),(102,'2022_12_11_052932_project_dependencies',4),(103,'2022_12_11_052941_project_task_documents',4),(104,'2022_12_11_053012_project_goals',4),(105,'2022_12_11_053041_project_milestone_employees',4),(106,'2022_12_11_071541_project_task_updates',4),(107,'2022_12_11_082259_project_task_coversations',4),(108,'2022_12_11_082333_project_task_coversation_messages',4),(109,'2022_12_11_083111_project_logs',4),(110,'2022_12_09_103629_tags',5),(111,'2022_12_09_103638_bank_accounts',5),(112,'2022_12_09_103652_fiscal_years',5),(113,'2022_12_09_103705_companies',5),(114,'2022_12_09_103716_profit_centres',5),(115,'2022_12_09_103722_cost_centres',5),(116,'2022_12_10_103920_currency_types',5),(117,'2022_12_10_103926_currencies',5),(118,'2022_12_10_103934_exchange_rates',5),(119,'2022_12_11_103540_ledger_classes',5),(120,'2022_12_11_103542_ledger_groups',5),(121,'2022_12_11_103546_ledgers',5),(122,'2022_12_11_103558_transaction_types',5),(123,'2022_12_11_103610_transactions',5),(124,'2022_12_11_103616_transaction_entries',5),(125,'2022_12_11_103759_finance_setups',5),(126,'2022_12_11_103846_advance_categories',5),(127,'2022_12_11_103911_bank_reconciliation_statements',5),(136,'2022_12_11_132248_skills',6),(137,'2022_12_11_132315_project_type_skills',6),(138,'2022_12_11_132338_task_skills',6),(139,'2022_12_11_132357_task_reviewers',6),(140,'2022_12_11_135619_task_skill_reviews',6),(141,'2023_01_24_173227_create_permission_tables',7),(142,'2023_01_25_142540_add_module_to_permissions',8),(143,'2023_01_25_173355_menu_permissions',9),(144,'2023_01_25_173400_submenu_permissions',9),(145,'2023_01_26_100950_user_column_visibilities',10),(163,'2023_02_18_121949_add_biotime_info_to_employee',15),(174,'2023_02_17_103933_biotime_areas',16),(175,'2023_02_17_104005_biotime_departments',16),(176,'2023_02_17_104022_biotime_positions',16),(177,'2023_02_17_104053_biotime_employees',16),(178,'2023_02_17_104126_biotime_devices',16),(179,'2023_02_17_104308_biotime_transactions',16),(180,'2023_02_17_122114_update_biotime_employees',16),(181,'2023_02_17_122701_employee_areas',16),(182,'2023_02_17_122830_remove_area_from_employees',16),(183,'2023_02_17_135045_add_id_to_all_tables',16),(187,'2023_02_23_063650_zkteco_devices',17),(188,'2023_02_23_063659_zkteco_checkinouts',17),(189,'2023_02_23_143620_zkteco_employees',17),(388,'2023_02_24_072815_requisition_types',18),(389,'2023_02_24_072827_add_requisition_types_to_requisitions',18),(694,'2023_02_24_073919_purchase_order_bills',19),(698,'2023_02_24_074048_good_received_notes',19),(699,'2023_02_24_074054_good_received_note_items',19),(873,'2023_02_24_074147_inventories',20),(876,'2023_02_24_074349_approval_ranges',20),(995,'2023_02_24_071932_vendors',21),(996,'2023_02_24_071949_categories',21),(997,'2023_02_24_071958_products',21),(998,'2023_02_24_072008_attributes',21),(999,'2023_02_24_072014_attribute_options',21),(1000,'2023_02_24_072026_product_attributes',21),(1001,'2023_02_24_072047_suppliers',21),(1002,'2023_02_24_072138_supplier_addresses',21),(1003,'2023_02_24_072155_supplier_bank_accounts',21),(1004,'2023_02_24_072204_supplier_contact_persons',21),(1005,'2023_02_24_072238_supplier_currencies',21),(1006,'2023_02_24_072248_payment_terms',21),(1007,'2023_02_24_072256_supplier_payment_terms',21),(1008,'2023_02_24_072304_review_criterias',21),(1009,'2023_02_24_072305_supplier_reviews',21),(1010,'2023_02_24_072314_supplier_logs',21),(1011,'2023_02_24_072333_supplier_products',21),(1012,'2023_02_24_072436_product_units',21),(1013,'2023_02_24_072505_product_available_units',21),(1014,'2023_02_24_072523_unit_conversions',21),(1015,'2023_02_24_072642_supplier_ledgers',21),(1016,'2023_02_24_072650_product_ledgers',21),(1017,'2023_02_24_072658_category_ledgers',21),(1018,'2023_02_24_072700_requisition_types',21),(1019,'2023_02_24_072753_requisitions',21),(1020,'2023_02_24_072846_requisition_items',21),(1021,'2023_02_24_072853_requisition_notes',21),(1022,'2023_02_24_072902_requisition_trackings',21),(1023,'2023_02_24_073008_warehouses',21),(1024,'2023_02_24_073016_units',21),(1025,'2023_02_24_073037_requisition_deliveries',21),(1026,'2023_02_24_073049_requisition_delivery_items',21),(1027,'2023_02_24_073134_proposals',21),(1028,'2023_02_24_073145_proposal_items',21),(1029,'2023_02_24_073154_proposal_requisitions',21),(1030,'2023_02_24_073201_proposal_trackings',21),(1031,'2023_02_24_073211_proposal_suppliers',21),(1032,'2023_02_24_073703_category_functions',21),(1033,'2023_02_24_073711_category_attributes',21),(1034,'2023_02_24_073812_quotations',21),(1035,'2023_02_24_073820_quotation_items',21),(1036,'2023_02_24_073830_purchase_orders',21),(1037,'2023_02_24_073851_purchase_order_items',21),(1038,'2023_02_24_073906_purchase_order_requisitions',21),(1039,'2023_02_24_073933_purchase_order_transactions',21),(1040,'2023_02_24_073934_good_received_notes',21),(1041,'2023_02_24_073935_good_received_note_items',21),(1042,'2023_02_24_073944_purchase_order_returns',21),(1043,'2023_02_24_074001_purchase_order_gate_outs',21),(1044,'2023_02_24_074102_stocks',21),(1045,'2023_02_24_074245_faqs',21),(1046,'2023_02_24_074331_supplier_transactions',21),(1047,'2023_02_24_074427_employee_warehouses',21),(1048,'2023_02_24_180234_product_vendors',21),(1049,'2023_02_25_073919_purchase_order_bills',21),(1050,'2023_02_26_162934_add_grn_to_bills',21),(1051,'2023_02_26_173942_return_faq',21),(1053,'2023_05_06_171151_add_columns_to_users',22),(1054,'2023_05_07_163251_departments',23),(1055,'2023_05_07_163325_courses',23),(1056,'2023_05_07_163355_user_courses',23),(1057,'2023_05_07_163431_add_department_to_users',23),(1058,'2023_05_07_163859_course_fees',23),(1059,'2023_05_07_163940_user_bills',24),(1060,'2023_05_07_163944_bill_collections',24);

/*Table structure for table `model_has_permissions` */

DROP TABLE IF EXISTS `model_has_permissions`;

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `model_has_permissions` */

/*Table structure for table `model_has_roles` */

DROP TABLE IF EXISTS `model_has_roles`;

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `model_has_roles` */

insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (1,'App\\Models\\User',1),(3,'App\\Models\\User',2),(3,'App\\Models\\User',3),(3,'App\\Models\\User',4);

/*Table structure for table `modules` */

DROP TABLE IF EXISTS `modules`;

CREATE TABLE `modules` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `route` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` text COLLATE utf8mb4_unicode_ci,
  `desc` text COLLATE utf8mb4_unicode_ci,
  `serial` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `modules` */

insert  into `modules`(`id`,`name`,`route`,`icon`,`desc`,`serial`,`status`,`created_at`,`updated_at`) values (6,'Setups','setups','fas fa-cogs',NULL,0,1,'2020-05-15 10:58:39','2023-01-26 17:44:13'),(22,'Fee Management','fee-management','fa fa-money-check-alt',NULL,5,1,'2023-05-07 14:34:12','2023-05-07 14:34:12');

/*Table structure for table `options` */

DROP TABLE IF EXISTS `options`;

CREATE TABLE `options` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` bigint(20) unsigned NOT NULL,
  `submenu_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` text COLLATE utf8mb4_unicode_ci,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `options_menu_id_foreign` (`menu_id`),
  KEY `options_submenu_id_foreign` (`submenu_id`),
  CONSTRAINT `options_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`),
  CONSTRAINT `options_submenu_id_foreign` FOREIGN KEY (`submenu_id`) REFERENCES `submenu` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `options` */

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `permissions` */

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `module` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4300 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `permissions` */

insert  into `permissions`(`id`,`module`,`name`,`guard_name`,`created_at`,`updated_at`) values (3835,'Reports','role-report-index','web',NULL,NULL),(3863,'Setups','system-information-index','web',NULL,NULL),(3864,'Setups','system-information-create','web',NULL,NULL),(3865,'Setups','system-information-edit','web',NULL,NULL),(3866,'Setups','system-information-delete','web',NULL,NULL),(3903,'Setups','system-settings-modules-index','web',NULL,NULL),(3904,'Setups','system-settings-modules-create','web',NULL,NULL),(3905,'Setups','system-settings-modules-edit','web',NULL,NULL),(3906,'Setups','system-settings-modules-delete','web',NULL,NULL),(3907,'Setups','system-settings-menu-index','web',NULL,NULL),(3908,'Setups','system-settings-menu-create','web',NULL,NULL),(3909,'Setups','system-settings-menu-edit','web',NULL,NULL),(3910,'Setups','system-settings-menu-delete','web',NULL,NULL),(3911,'Setups','system-settings-submenu-index','web',NULL,NULL),(3912,'Setups','system-settings-submenu-create','web',NULL,NULL),(3913,'Setups','system-settings-submenu-edit','web',NULL,NULL),(3914,'Setups','system-settings-submenu-delete','web',NULL,NULL),(3915,'Setups','role-management-roles-index','web',NULL,NULL),(3916,'Setups','role-management-roles-create','web',NULL,NULL),(3917,'Setups','role-management-roles-edit','web',NULL,NULL),(3918,'Setups','role-management-roles-delete','web',NULL,NULL),(3919,'Setups','role-management-role-permissions-index','web',NULL,NULL),(3920,'Setups','role-management-role-permissions-create','web',NULL,NULL),(3921,'Setups','role-management-role-permissions-edit','web',NULL,NULL),(3922,'Setups','role-management-role-permissions-delete','web',NULL,NULL),(4247,'Setups','role-management-permissions-index','web',NULL,NULL),(4248,'Setups','role-management-permissions-create','web',NULL,NULL),(4249,'Setups','role-management-permissions-edit','web',NULL,NULL),(4250,'Setups','role-management-permissions-delete','web',NULL,NULL),(4267,'Setups','role-management-user-index','web','2023-05-07 12:53:50','2023-05-07 12:53:50'),(4268,'Setups','role-management-user-create','web','2023-05-07 12:54:00','2023-05-07 12:54:00'),(4269,'Setups','role-management-user-edit','web','2023-05-07 12:54:07','2023-05-07 12:54:07'),(4270,'Setups','role-management-user-delete','web','2023-05-07 12:54:14','2023-05-07 12:54:14'),(4271,'Reports','role-report-print','web','2023-05-07 13:06:14','2023-05-07 13:06:32'),(4272,'Reports','role-report-pdf','web','2023-05-07 13:06:41','2023-05-07 13:06:41'),(4273,'Reports','role-report-excel','web','2023-05-07 13:06:49','2023-05-07 13:06:49'),(4274,'Setups','department-index','web','2023-05-07 14:36:16','2023-05-07 14:36:16'),(4275,'Setups','department-create','web','2023-05-07 14:36:33','2023-05-07 14:36:33'),(4276,'Setups','department-edit','web','2023-05-07 14:36:33','2023-05-07 14:36:33'),(4277,'Setups','department-delete','web','2023-05-07 14:36:33','2023-05-07 14:36:33'),(4278,'Setups','course-index','web','2023-05-07 14:36:58','2023-05-07 14:36:58'),(4279,'Setups','course-create','web','2023-05-07 14:36:58','2023-05-07 14:36:58'),(4280,'Setups','course-edit','web','2023-05-07 14:36:58','2023-05-07 14:36:58'),(4281,'Setups','course-delete','web','2023-05-07 14:36:58','2023-05-07 14:36:58'),(4286,'Fee Management','fee-collections','web','2023-05-07 14:38:11','2023-05-07 14:38:11'),(4287,'Fee Management','collect-fee','web','2023-05-07 14:38:11','2023-05-07 14:38:11'),(4288,'Fee Management','view-fee-collections','web','2023-05-07 14:38:11','2023-05-07 14:38:11'),(4289,'Fee Management','user-courses','web','2023-05-08 14:59:10','2023-05-08 14:59:10'),(4290,'Fee Management','update-user-courses','web','2023-05-08 14:59:10','2023-05-08 14:59:10'),(4291,'Fee Management','course-fees-index','web','2023-05-09 12:26:58','2023-05-09 12:26:58'),(4292,'Fee Management','course-fees-create','web','2023-05-09 12:26:58','2023-05-09 12:26:58'),(4293,'Fee Management','course-fees-edit','web','2023-05-09 12:26:58','2023-05-09 12:26:58'),(4294,'Fee Management','course-fees-delete','web','2023-05-09 12:26:58','2023-05-09 12:26:58'),(4295,'Fee Management','user-bills-index','web','2023-05-09 12:50:23','2023-05-09 12:51:00'),(4296,'Fee Management','user-bills-create','web','2023-05-09 12:50:23','2023-05-09 12:50:23'),(4297,'Fee Management','user-bills-edit','web','2023-05-09 12:50:23','2023-05-09 12:50:23'),(4298,'Fee Management','user-bills-delete','web','2023-05-09 12:50:23','2023-05-09 12:50:23'),(4299,'Fee Management','notifications','web','2023-05-10 15:31:28','2023-05-10 15:31:28');

/*Table structure for table `personal_access_tokens` */

DROP TABLE IF EXISTS `personal_access_tokens`;

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `personal_access_tokens` */

/*Table structure for table `role_has_permissions` */

DROP TABLE IF EXISTS `role_has_permissions`;

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `role_has_permissions` */

insert  into `role_has_permissions`(`permission_id`,`role_id`) values (3835,1),(3863,1),(3864,1),(3865,1),(3866,1),(3903,1),(3904,1),(3905,1),(3906,1),(3907,1),(3908,1),(3909,1),(3910,1),(3911,1),(3912,1),(3913,1),(3914,1),(3915,1),(3916,1),(3917,1),(3918,1),(3919,1),(3920,1),(3921,1),(3922,1),(4247,1),(4248,1),(4249,1),(4250,1),(4267,1),(4268,1),(4269,1),(4270,1),(4271,1),(4272,1),(4273,1),(4274,1),(4275,1),(4276,1),(4277,1),(4278,1),(4279,1),(4280,1),(4281,1),(4286,1),(4287,1),(4288,1),(4289,1),(4290,1),(4291,1),(4292,1),(4293,1),(4294,1),(4295,1),(4296,1),(4297,1),(4298,1),(4299,1),(3835,2),(3863,2),(3864,2),(3865,2),(3866,2),(4267,2),(4268,2),(4269,2),(4270,2),(4271,2),(4272,2),(4273,2),(4274,2),(4275,2),(4276,2),(4277,2),(4278,2),(4279,2),(4280,2),(4281,2),(4286,2),(4287,2),(4288,2),(4289,2),(4290,2);

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `roles` */

insert  into `roles`(`id`,`name`,`guard_name`,`created_at`,`updated_at`) values (1,'Super Admin','web','2023-01-25 15:51:05','2023-01-25 15:51:05'),(2,'Admin','web','2023-01-25 15:51:05','2023-01-25 15:51:05'),(3,'Student','web','2023-01-25 15:51:05','2023-05-07 12:46:06');

/*Table structure for table `sub_functions` */

DROP TABLE IF EXISTS `sub_functions`;

CREATE TABLE `sub_functions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `function_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` text COLLATE utf8mb4_unicode_ci,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sub_functions_function_id_foreign` (`function_id`),
  CONSTRAINT `sub_functions_function_id_foreign` FOREIGN KEY (`function_id`) REFERENCES `functions` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sub_functions` */

insert  into `sub_functions`(`id`,`function_id`,`name`,`desc`,`status`,`created_at`,`updated_at`) values (3,1,'Design',NULL,1,'2020-05-18 10:26:04','2020-05-28 09:07:21'),(4,1,'Development',NULL,1,'2020-05-18 10:26:10','2020-05-28 09:07:56'),(5,2,'Management',NULL,1,'2020-05-28 09:07:43','2020-05-28 09:08:03'),(6,3,'Software Development',NULL,1,'2020-05-28 09:08:13','2020-05-28 09:08:47'),(8,4,'Digital Marketing',NULL,1,'2020-05-28 09:09:02','2020-05-28 09:09:02');

/*Table structure for table `submenu` */

DROP TABLE IF EXISTS `submenu`;

CREATE TABLE `submenu` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `route` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` text COLLATE utf8mb4_unicode_ci,
  `desc` text COLLATE utf8mb4_unicode_ci,
  `serial` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `submenu_menu_id_foreign` (`menu_id`),
  CONSTRAINT `submenu_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `submenu` */

insert  into `submenu`(`id`,`menu_id`,`name`,`route`,`icon`,`desc`,`serial`,`status`,`created_at`,`updated_at`) values (1,8,'Modules','modules','fa fa-tasks',NULL,1,1,'2020-05-15 13:46:36','2020-05-15 13:46:36'),(2,8,'Menu','menu','fa fa-tasks',NULL,2,1,'2020-05-15 13:47:39','2020-05-15 13:47:39'),(3,8,'Submenu','submenu','fa fa-tasks',NULL,3,1,'2020-05-15 13:47:52','2020-05-15 13:47:52'),(5,10,'Roles','roles','fab fa-accessible-icon',NULL,1,1,'2020-05-15 17:40:50','2020-05-15 17:40:50'),(6,10,'Role Permissions','role-permissions','fab fa-angellist',NULL,0,1,'2020-05-15 17:42:12','2020-05-15 17:42:12'),(93,10,'Permissions','permissions','fas fa-question-circle',NULL,2,1,'2023-01-25 14:10:26','2023-05-07 12:44:41'),(95,79,'Departments','departments',NULL,NULL,1,1,'2023-05-07 14:33:06','2023-05-07 14:33:06'),(96,79,'Courses','courses',NULL,NULL,2,1,'2023-05-07 14:33:24','2023-05-07 14:33:24');

/*Table structure for table `submenu_permissions` */

DROP TABLE IF EXISTS `submenu_permissions`;

CREATE TABLE `submenu_permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `submenu_id` bigint(20) unsigned NOT NULL,
  `permission_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `submenu_permissions_submenu_id_foreign` (`submenu_id`),
  KEY `submenu_permissions_permission_id_foreign` (`permission_id`),
  CONSTRAINT `submenu_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `submenu_permissions_submenu_id_foreign` FOREIGN KEY (`submenu_id`) REFERENCES `submenu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=707 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `submenu_permissions` */

insert  into `submenu_permissions`(`id`,`submenu_id`,`permission_id`,`created_at`,`updated_at`) values (350,1,3903,NULL,NULL),(351,1,3904,NULL,NULL),(352,1,3905,NULL,NULL),(353,1,3906,NULL,NULL),(354,2,3907,NULL,NULL),(355,2,3908,NULL,NULL),(356,2,3909,NULL,NULL),(357,2,3910,NULL,NULL),(358,3,3911,NULL,NULL),(359,3,3912,NULL,NULL),(360,3,3913,NULL,NULL),(361,3,3914,NULL,NULL),(362,5,3915,NULL,NULL),(363,5,3916,NULL,NULL),(364,5,3917,NULL,NULL),(365,5,3918,NULL,NULL),(366,6,3919,NULL,NULL),(367,6,3920,NULL,NULL),(368,6,3921,NULL,NULL),(369,6,3922,NULL,NULL),(694,93,4247,NULL,NULL),(695,93,4248,NULL,NULL),(696,93,4249,NULL,NULL),(697,93,4250,NULL,NULL),(699,95,4274,'2023-05-07 14:39:30','2023-05-07 14:39:30'),(700,95,4275,'2023-05-07 14:39:30','2023-05-07 14:39:30'),(701,95,4276,'2023-05-07 14:39:30','2023-05-07 14:39:30'),(702,95,4277,'2023-05-07 14:39:30','2023-05-07 14:39:30'),(703,96,4278,'2023-05-07 14:39:39','2023-05-07 14:39:39'),(704,96,4279,'2023-05-07 14:39:39','2023-05-07 14:39:39'),(705,96,4280,'2023-05-07 14:39:39','2023-05-07 14:39:39'),(706,96,4281,'2023-05-07 14:39:39','2023-05-07 14:39:39');

/*Table structure for table `system_information` */

DROP TABLE IF EXISTS `system_information`;

CREATE TABLE `system_information` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `motto` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tagline` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `website` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `twitter` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `facebook` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `instagram` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `skype` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `linked_in` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `secondary_logo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `system_information` */

insert  into `system_information`(`id`,`name`,`description`,`motto`,`tagline`,`phone`,`mobile`,`address`,`email`,`website`,`twitter`,`facebook`,`instagram`,`skype`,`linked_in`,`logo`,`secondary_logo`,`icon`,`status`,`created_at`,`updated_at`) values (1,'Edufee','Edufee','Edufee','Edufee','01234567890','01234567890','World','Edufee@email.com','https://deskplusbd.com','https://twitter.com','https://facebook.com','https://instagram.com','https://skype.com','https://bd.linkedin.com','1-20230507135237-1942220470-1420625974.jpg','1-20230507135248-1958906032-181655368.jpg','1-20230507135328-561200201-1133207393.jpg',1,NULL,'2023-05-10 17:25:10');

/*Table structure for table `user_bill_collections` */

DROP TABLE IF EXISTS `user_bill_collections`;

CREATE TABLE `user_bill_collections` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_bill_id` bigint(20) unsigned NOT NULL,
  `date` date NOT NULL,
  `collection` double NOT NULL DEFAULT '0',
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_bill_collections_user_bill_id_foreign` (`user_bill_id`),
  CONSTRAINT `user_bill_collections_user_bill_id_foreign` FOREIGN KEY (`user_bill_id`) REFERENCES `user_bills` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `user_bill_collections` */

insert  into `user_bill_collections`(`id`,`user_bill_id`,`date`,`collection`,`description`,`created_at`,`updated_at`) values (1,1,'2023-05-09',500,NULL,'2023-05-09 15:57:00','2023-05-09 15:57:00'),(2,2,'2023-05-09',1000,NULL,'2023-05-09 15:57:00','2023-05-09 15:57:00'),(3,1,'2023-05-09',1000,NULL,'2023-05-09 15:57:05','2023-05-09 15:57:05'),(4,2,'2023-05-09',1000,NULL,'2023-05-09 15:57:30','2023-05-09 15:57:30');

/*Table structure for table `user_bills` */

DROP TABLE IF EXISTS `user_bills`;

CREATE TABLE `user_bills` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_course_id` bigint(20) unsigned NOT NULL,
  `deadline` date NOT NULL,
  `fee` double NOT NULL DEFAULT '0',
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_bills_user_course_id_foreign` (`user_course_id`),
  CONSTRAINT `user_bills_user_course_id_foreign` FOREIGN KEY (`user_course_id`) REFERENCES `user_courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `user_bills` */

insert  into `user_bills`(`id`,`user_course_id`,`deadline`,`fee`,`description`,`created_at`,`updated_at`) values (1,2,'2023-05-09',1500,NULL,'2023-05-09 14:13:45','2023-05-09 14:13:45'),(2,7,'2023-05-09',2000,NULL,'2023-05-09 14:13:45','2023-05-09 14:13:45'),(3,3,'2023-05-09',1500,NULL,'2023-05-09 15:36:09','2023-05-09 15:36:09'),(4,4,'2023-05-09',2000,NULL,'2023-05-09 15:36:09','2023-05-09 15:36:09'),(5,5,'2023-05-09',1500,NULL,'2023-05-09 15:36:17','2023-05-09 15:36:17'),(6,6,'2023-05-09',2000,NULL,'2023-05-09 15:36:17','2023-05-09 15:36:17');

/*Table structure for table `user_column_visibilities` */

DROP TABLE IF EXISTS `user_column_visibilities`;

CREATE TABLE `user_column_visibilities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `url` text COLLATE utf8mb4_unicode_ci,
  `columns` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_column_visibilities_user_id_foreign` (`user_id`),
  CONSTRAINT `user_column_visibilities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `user_column_visibilities` */

insert  into `user_column_visibilities`(`id`,`user_id`,`url`,`columns`,`created_at`,`updated_at`) values (1,1,'http://localhost:8000/setups/permissions','[\"true\",\"true\",\"true\",\"true\",\"true\"]','2023-01-26 14:52:28','2023-01-26 14:52:51'),(2,1,'http://localhost:8000/biotime/biotime-employees','[\"true\",\"true\",\"true\",\"true\",\"true\",\"true\",\"true\",\"true\",\"true\",\"true\",\"false\",\"false\",\"false\",\"true\",\"false\",\"false\",\"false\",\"true\"]','2023-02-22 16:26:55','2023-02-22 16:27:03');

/*Table structure for table `user_courses` */

DROP TABLE IF EXISTS `user_courses`;

CREATE TABLE `user_courses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `course_id` bigint(20) unsigned NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_courses_user_id_foreign` (`user_id`),
  KEY `user_courses_course_id_foreign` (`course_id`),
  CONSTRAINT `user_courses_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_courses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `user_courses` */

insert  into `user_courses`(`id`,`user_id`,`course_id`,`description`,`created_at`,`updated_at`) values (2,2,1,NULL,'2023-05-08 15:42:48','2023-05-08 15:42:48'),(3,3,1,NULL,'2023-05-08 15:42:59','2023-05-08 15:42:59'),(4,3,2,NULL,'2023-05-08 15:42:59','2023-05-08 15:42:59'),(5,4,1,NULL,'2023-05-08 15:43:06','2023-05-08 15:43:06'),(6,4,2,NULL,'2023-05-08 15:43:06','2023-05-08 15:43:06'),(7,2,2,NULL,'2023-05-08 15:43:21','2023-05-08 15:43:21');

/*Table structure for table `user_departments` */

DROP TABLE IF EXISTS `user_departments`;

CREATE TABLE `user_departments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `department_id` bigint(20) unsigned NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_departments_user_id_foreign` (`user_id`),
  KEY `user_departments_department_id_foreign` (`department_id`),
  CONSTRAINT `user_departments_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_departments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `user_departments` */

insert  into `user_departments`(`id`,`user_id`,`department_id`,`description`,`created_at`,`updated_at`) values (1,2,2,NULL,'2023-05-09 12:10:41','2023-05-09 12:10:41'),(2,3,2,NULL,'2023-05-09 12:10:45','2023-05-09 12:10:45'),(3,4,2,NULL,'2023-05-09 12:10:49','2023-05-09 12:10:49');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` int(11) NOT NULL DEFAULT '1',
  `image` text COLLATE utf8mb4_unicode_ci,
  `is_developer` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`first_name`,`last_name`,`email`,`username`,`email_verified_at`,`password`,`gender`,`image`,`is_developer`,`status`,`remember_token`,`created_at`,`updated_at`) values (1,'Super','Admin','super-admin@email.com','super-admin',NULL,'$2y$10$GsBtzoavbWj9jBaubL2CDOYQr8QjzsN305.e40iIrnMyW2fh4mGVW',1,'1-20230507135058-1036640678-1171789914.png',1,1,NULL,'2022-08-23 21:20:45','2023-05-07 13:50:58'),(2,'Student','One','anwarullah834@gmail.com','student-1',NULL,'$2y$10$KOwH2baqBLtLeGOND3ELBOIwCWRn.A.aq780U2Wri9eAae7P85zF2',1,NULL,0,1,NULL,'2023-05-08 14:54:28','2023-05-08 14:54:28'),(3,'Student','Two','anwarullah834@gmail.com','student-2',NULL,'$2y$10$mBPOWLKtfsNi1ojucwCFne0e6BvPn/5ktIS1/7xP49UCNaEr93ZWC',1,NULL,0,1,NULL,'2023-05-08 14:54:51','2023-05-08 14:54:51'),(4,'Student','Three','anwarullah834@gmail.com','student-3',NULL,'$2y$10$5vObzEw1QSJt2ZcnQHUcoeD37OdcDIvyxTRBZLUZYe9AnJkw0xkYy',1,NULL,0,1,NULL,'2023-05-08 14:55:26','2023-05-08 14:55:26');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
