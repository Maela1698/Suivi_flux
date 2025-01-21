insert into acteurTiers(acteur) values ('Client');
insert into acteurTiers(acteur) values ('Fournisseur');
insert into acteurTiers(acteur) values ('Prospect');

--pays
INSERT INTO pays(id, code, alpha2, alpha3, nom_en_gb, nom_fr_fr) VALUES
(1, 4, 'AF', 'AFG', 'Afghanistan', 'Afghanistan'),
(2, 8, 'AL', 'ALB', 'Albania', 'Albanie'),
(3, 10, 'AQ', 'ATA', 'Antarctica', 'Antarctique'),
(4, 12, 'DZ', 'DZA', 'Algeria', 'Algerie'),
(5, 16, 'AS', 'ASM', 'American Samoa', 'Samoa Americaines'),
(6, 20, 'AD', 'AND', 'Andorra', 'Andorre'),
(7, 24, 'AO', 'AGO', 'Angola', 'Angola'),
(8, 28, 'AG', 'ATG', 'Antigua and Barbuda', 'Antigua-et-Barbuda'),
(9, 31, 'AZ', 'AZE', 'Azerbaijan', 'Azerbaïdjan'),
(10, 32, 'AR', 'ARG', 'Argentina', 'Argentine'),
(11, 36, 'AU', 'AUS', 'Australia', 'Australie'),
(12, 40, 'AT', 'AUT', 'Austria', 'Autriche'),
(13, 44, 'BS', 'BHS', 'Bahamas', 'Bahamas'),
(14, 48, 'BH', 'BHR', 'Bahrain', 'Bahreïn'),
(15, 50, 'BD', 'BGD', 'Bangladesh', 'Bangladesh'),
(16, 51, 'AM', 'ARM', 'Armenia', 'Armenie'),
(17, 52, 'BB', 'BRB', 'Barbados', 'Barbade'),
(18, 56, 'BE', 'BEL', 'Belgium', 'Belgique'),
(19, 60, 'BM', 'BMU', 'Bermuda', 'Bermudes'),
(20, 64, 'BT', 'BTN', 'Bhutan', 'Bhoutan'),
(21, 68, 'BO', 'BOL', 'Bolivia', 'Bolivie'),
(22, 70, 'BA', 'BIH', 'Bosnia and Herzegovina', 'Bosnie-Herzegovine'),
(23, 72, 'BW', 'BWA', 'Botswana', 'Botswana'),
(24, 74, 'BV', 'BVT', 'Bouvet Island', 'Ile Bouvet'),
(25, 76, 'BR', 'BRA', 'Brazil', 'Bresil'),
(26, 84, 'BZ', 'BLZ', 'Belize', 'Belize'),
(27, 86, 'IO', 'IOT', 'British Indian Ocean Territory', 'Territoire Britannique de l''Ocean Indien'),
(28, 90, 'SB', 'SLB', 'Solomon Islands', 'Iles Salomon'),
(29, 92, 'VG', 'VGB', 'British Virgin Islands', 'Iles Vierges Britanniques'),
(30, 96, 'BN', 'BRN', 'Brunei Darussalam', 'Brunei Darussalam'),
(31, 100, 'BG', 'BGR', 'Bulgaria', 'Bulgarie'),
(32, 104, 'MM', 'MMR', 'Myanmar', 'Myanmar'),
(33, 108, 'BI', 'BDI', 'Burundi', 'Burundi'),
(34, 112, 'BY', 'BLR', 'Belarus', 'Belarus'),
(35, 116, 'KH', 'KHM', 'Cambodia', 'Cambodge'),
(36, 120, 'CM', 'CMR', 'Cameroon', 'Cameroun'),
(37, 124, 'CA', 'CAN', 'Canada', 'Canada'),
(38, 132, 'CV', 'CPV', 'Cape Verde', 'Cap-vert'),
(39, 136, 'KY', 'CYM', 'Cayman Islands', 'Iles Caïmanes'),
(40, 140, 'CF', 'CAF', 'Central African', 'Republique Centrafricaine'),
(41, 144, 'LK', 'LKA', 'Sri Lanka', 'Sri Lanka'),
(42, 148, 'TD', 'TCD', 'Chad', 'Tchad'),
(43, 152, 'CL', 'CHL', 'Chile', 'Chili'),
(44, 156, 'CN', 'CHN', 'China', 'Chine'),
(45, 158, 'TW', 'TWN', 'Taiwan', 'Taïwan'),
(46, 162, 'CX', 'CXR', 'Christmas Island', 'Ile Christmas'),
(47, 166, 'CC', 'CCK', 'Cocos (Keeling) Islands', 'Iles Cocos (Keeling)'),
(48, 170, 'CO', 'COL', 'Colombia', 'Colombie'),
(49, 174, 'KM', 'COM', 'Comoros', 'Comores'),
(50, 175, 'YT', 'MYT', 'Mayotte', 'Mayotte'),
(51, 178, 'CG', 'COG', 'Republic of the Congo', 'Republique du Congo'),
(52, 180, 'CD', 'COD', 'The Democratic Republic Of The Congo', 'Republique Democratique du Congo'),
(53, 184, 'CK', 'COK', 'Cook Islands', 'Iles Cook'),
(54, 188, 'CR', 'CRI', 'Costa Rica', 'Costa Rica'),
(55, 191, 'HR', 'HRV', 'Croatia', 'Croatie'),
(56, 192, 'CU', 'CUB', 'Cuba', 'Cuba'),
(57, 196, 'CY', 'CYP', 'Cyprus', 'Chypre'),
(58, 203, 'CZ', 'CZE', 'Czech Republic', 'Republique Tcheque'),
(59, 204, 'BJ', 'BEN', 'Benin', 'Benin'),
(60, 208, 'DK', 'DNK', 'Denmark', 'Danemark'),
(61, 212, 'DM', 'DMA', 'Dominica', 'Dominique'),
(62, 214, 'DO', 'DOM', 'Dominican Republic', 'Republique Dominicaine'),
(63, 218, 'EC', 'ECU', 'Ecuador', 'Equateur'),
(64, 222, 'SV', 'SLV', 'El Salvador', 'El Salvador'),
(65, 226, 'GQ', 'GNQ', 'Equatorial Guinea', 'Guinee Equatoriale'),
(66, 231, 'ET', 'ETH', 'Ethiopia', 'Ethiopie'),
(67, 232, 'ER', 'ERI', 'Eritrea', 'Erythree'),
(68, 233, 'EE', 'EST', 'Estonia', 'Estonie'),
(69, 234, 'FO', 'FRO', 'Faroe Islands', 'Iles Feroe'),
(70, 238, 'FK', 'FLK', 'Falkland Islands', 'Iles (malvinas) Falkland'),
(71, 239, 'GS', 'SGS', 'South Georgia and the South Sandwich Islands', 'Georgie du Sud et les Iles Sandwich du Sud'),
(72, 242, 'FJ', 'FJI', 'Fiji', 'Fidji'),
(73, 246, 'FI', 'FIN', 'Finland', 'Finlande'),
(74, 248, 'AX', 'ALA', 'Aland Islands', 'Iles Aland'),
(75, 250, 'FR', 'FRA', 'France', 'France'),
(76, 254, 'GF', 'GUF', 'French Guiana', 'Guyane Française'),
(77, 258, 'PF', 'PYF', 'French Polynesia', 'Polynesie Française'),
(78, 260, 'TF', 'ATF', 'French Southern Territories', 'Terres Australes Françaises'),
(79, 262, 'DJ', 'DJI', 'Djibouti', 'Djibouti'),
(80, 266, 'GA', 'GAB', 'Gabon', 'Gabon'),
(81, 268, 'GE', 'GEO', 'Georgia', 'Georgie'),
(82, 270, 'GM', 'GMB', 'Gambia', 'Gambie'),
(83, 275, 'PS', 'PSE', 'Occupied Palestinian Territory', 'Territoire Palestinien Occupe'),
(84, 276, 'DE', 'DEU', 'Germany', 'Allemagne'),
(85, 288, 'GH', 'GHA', 'Ghana', 'Ghana'),
(86, 292, 'GI', 'GIB', 'Gibraltar', 'Gibraltar'),
(87, 296, 'KI', 'KIR', 'Kiribati', 'Kiribati'),
(88, 300, 'GR', 'GRC', 'Greece', 'Grece'),
(89, 304, 'GL', 'GRL', 'Greenland', 'Groenland'),
(90, 308, 'GD', 'GRD', 'Grenada', 'Grenade'),
(91, 312, 'GP', 'GLP', 'Guadeloupe', 'Guadeloupe'),
(92, 316, 'GU', 'GUM', 'Guam', 'Guam'),
(93, 320, 'GT', 'GTM', 'Guatemala', 'Guatemala'),
(94, 324, 'GN', 'GIN', 'Guinea', 'Guinee'),
(95, 328, 'GY', 'GUY', 'Guyana', 'Guyana'),
(96, 332, 'HT', 'HTI', 'Haiti', 'Haïti'),
(97, 334, 'HM', 'HMD', 'Heard Island and McDonald Islands', 'Iles Heard et Mcdonald'),
(98, 336, 'VA', 'VAT', 'Vatican City State', 'Saint-Siege (etat de la Cite du Vatican)'),
(99, 340, 'HN', 'HND', 'Honduras', 'Honduras'),
(100, 344, 'HK', 'HKG', 'Hong Kong', 'Hong-Kong'),
(101, 348, 'HU', 'HUN', 'Hungary', 'Hongrie'),
(102, 352, 'IS', 'ISL', 'Iceland', 'Islande'),
(103, 356, 'IN', 'IND', 'India', 'Inde'),
(104, 360, 'ID', 'IDN', 'Indonesia', 'Indonesie'),
(105, 364, 'IR', 'IRN', 'Islamic Republic of Iran', 'Republique Islamique d''Iran'),
(106, 368, 'IQ', 'IRQ', 'Iraq', 'Iraq'),
(107, 372, 'IE', 'IRL', 'Ireland', 'Irlande'),
(108, 376, 'IL', 'ISR', 'Israel', 'Israël'),
(109, 380, 'IT', 'ITA', 'Italy', 'Italie'),
(110, 384, 'CI', 'CIV', 'Côte d''Ivoire', 'Côte d''Ivoire'),
(111, 388, 'JM', 'JAM', 'Jamaica', 'Jamaïque'),
(112, 392, 'JP', 'JPN', 'Japan', 'Japon'),
(113, 398, 'KZ', 'KAZ', 'Kazakhstan', 'Kazakhstan'),
(114, 400, 'JO', 'JOR', 'Jordan', 'Jordanie'),
(115, 404, 'KE', 'KEN', 'Kenya', 'Kenya'),
(116, 408, 'KP', 'PRK', 'Democratic People''s Republic of Korea', 'Republique Populaire Democratique de Coree'),
(117, 410, 'KR', 'KOR', 'Republic of Korea', 'Republique de Coree'),
(118, 414, 'KW', 'KWT', 'Kuwait', 'Koweït'),
(119, 417, 'KG', 'KGZ', 'Kyrgyzstan', 'Kirghizistan'),
(120, 418, 'LA', 'LAO', 'Lao People''s Democratic Republic', 'Republique Democratique Populaire Lao'),
(121, 422, 'LB', 'LBN', 'Lebanon', 'Liban'),
(122, 426, 'LS', 'LSO', 'Lesotho', 'Lesotho'),
(123, 428, 'LV', 'LVA', 'Latvia', 'Lettonie'),
(124, 430, 'LR', 'LBR', 'Liberia', 'Liberia'),
(125, 434, 'LY', 'LBY', 'Libyan Arab Jamahiriya', 'Jamahiriya Arabe Libyenne'),
(126, 438, 'LI', 'LIE', 'Liechtenstein', 'Liechtenstein'),
(127, 440, 'LT', 'LTU', 'Lithuania', 'Lituanie'),
(128, 442, 'LU', 'LUX', 'Luxembourg', 'Luxembourg'),
(129, 446, 'MO', 'MAC', 'Macao', 'Macao'),
(130, 450, 'MG', 'MDG', 'Madagascar', 'Madagascar'),
(131, 454, 'MW', 'MWI', 'Malawi', 'Malawi'),
(132, 458, 'MY', 'MYS', 'Malaysia', 'Malaisie'),
(133, 462, 'MV', 'MDV', 'Maldives', 'Maldives'),
(134, 466, 'ML', 'MLI', 'Mali', 'Mali'),
(135, 470, 'MT', 'MLT', 'Malta', 'Malte'),
(136, 474, 'MQ', 'MTQ', 'Martinique', 'Martinique'),
(137, 478, 'MR', 'MRT', 'Mauritania', 'Mauritanie'),
(138, 480, 'MU', 'MUS', 'Mauritius', 'Maurice'),
(139, 484, 'MX', 'MEX', 'Mexico', 'Mexique'),
(140, 492, 'MC', 'MCO', 'Monaco', 'Monaco'),
(141, 496, 'MN', 'MNG', 'Mongolia', 'Mongolie'),
(142, 498, 'MD', 'MDA', 'Republic of Moldova', 'Republique de Moldova'),
(143, 500, 'MS', 'MSR', 'Montserrat', 'Montserrat'),
(144, 504, 'MA', 'MAR', 'Morocco', 'Maroc'),
(145, 508, 'MZ', 'MOZ', 'Mozambique', 'Mozambique'),
(146, 512, 'OM', 'OMN', 'Oman', 'Oman'),
(147, 516, 'NA', 'NAM', 'Namibia', 'Namibie'),
(148, 520, 'NR', 'NRU', 'Nauru', 'Nauru'),
(149, 524, 'NP', 'NPL', 'Nepal', 'Nepal'),
(150, 528, 'NL', 'NLD', 'Netherlands', 'Pays-Bas'),
(151, 530, 'AN', 'ANT', 'Netherlands Antilles', 'Antilles Neerlandaises'),
(152, 533, 'AW', 'ABW', 'Aruba', 'Aruba'),
(153, 540, 'NC', 'NCL', 'New Caledonia', 'Nouvelle-Caledonie'),
(154, 548, 'VU', 'VUT', 'Vanuatu', 'Vanuatu'),
(155, 554, 'NZ', 'NZL', 'New Zealand', 'Nouvelle-Zelande'),
(156, 558, 'NI', 'NIC', 'Nicaragua', 'Nicaragua'),
(157, 562, 'NE', 'NER', 'Niger', 'Niger'),
(158, 566, 'NG', 'NGA', 'Nigeria', 'Nigeria'),
(159, 570, 'NU', 'NIU', 'Niue', 'Niue'),
(160, 574, 'NF', 'NFK', 'Norfolk Island', 'Ile Norfolk'),
(161, 578, 'NO', 'NOR', 'Norway', 'Norvege'),
(162, 580, 'MP', 'MNP', 'Northern Mariana Islands', 'Iles Mariannes du Nord'),
(163, 581, 'UM', 'UMI', 'United States Minor Outlying Islands', 'Iles Mineures Eloignees des Etats-Unis'),
(164, 583, 'FM', 'FSM', 'Federated States of Micronesia', 'Etats Federes de Micronesie'),
(165, 584, 'MH', 'MHL', 'Marshall Islands', 'Iles Marshall'),
(166, 585, 'PW', 'PLW', 'Palau', 'Palaos'),
(167, 586, 'PK', 'PAK', 'Pakistan', 'Pakistan'),
(168, 591, 'PA', 'PAN', 'Panama', 'Panama'),
(169, 598, 'PG', 'PNG', 'Papua New Guinea', 'Papouasie-Nouvelle-Guinee'),
(170, 600, 'PY', 'PRY', 'Paraguay', 'Paraguay'),
(171, 604, 'PE', 'PER', 'Peru', 'Perou'),
(172, 608, 'PH', 'PHL', 'Philippines', 'Philippines'),
(173, 612, 'PN', 'PCN', 'Pitcairn', 'Pitcairn'),
(174, 616, 'PL', 'POL', 'Poland', 'Pologne'),
(175, 620, 'PT', 'PRT', 'Portugal', 'Portugal'),
(176, 624, 'GW', 'GNB', 'Guinea-Bissau', 'Guinee-Bissau'),
(177, 626, 'TL', 'TLS', 'Timor-Leste', 'Timor-Leste'),
(178, 630, 'PR', 'PRI', 'Puerto Rico', 'Porto Rico'),
(179, 634, 'QA', 'QAT', 'Qatar', 'Qatar'),
(180, 638, 'RE', 'REU', 'Reunion', 'Reunion'),
(181, 642, 'RO', 'ROU', 'Romania', 'Roumanie'),
(182, 643, 'RU', 'RUS', 'Russian Federation', 'Federation de Russie'),
(183, 646, 'RW', 'RWA', 'Rwanda', 'Rwanda'),
(184, 654, 'SH', 'SHN', 'Saint Helena', 'Sainte-Helene'),
(185, 659, 'KN', 'KNA', 'Saint Kitts and Nevis', 'Saint-Kitts-et-Nevis'),
(186, 660, 'AI', 'AIA', 'Anguilla', 'Anguilla'),
(187, 662, 'LC', 'LCA', 'Saint Lucia', 'Sainte-Lucie'),
(188, 666, 'PM', 'SPM', 'Saint-Pierre and Miquelon', 'Saint-Pierre-et-Miquelon'),
(189, 670, 'VC', 'VCT', 'Saint Vincent and the Grenadines', 'Saint-Vincent-et-les Grenadines'),
(190, 674, 'SM', 'SMR', 'San Marino', 'Saint-Marin'),
(191, 678, 'ST', 'STP', 'Sao Tome and Principe', 'Sao Tome-et-Principe'),
(192, 682, 'SA', 'SAU', 'Saudi Arabia', 'Arabie Saoudite'),
(193, 686, 'SN', 'SEN', 'Senegal', 'Senegal'),
(194, 690, 'SC', 'SYC', 'Seychelles', 'Seychelles'),
(195, 694, 'SL', 'SLE', 'Sierra Leone', 'Sierra Leone'),
(196, 702, 'SG', 'SGP', 'Singapore', 'Singapour'),
(197, 703, 'SK', 'SVK', 'Slovakia', 'Slovaquie'),
(198, 704, 'VN', 'VNM', 'Vietnam', 'Viet Nam'),
(199, 705, 'SI', 'SVN', 'Slovenia', 'Slovenie'),
(200, 706, 'SO', 'SOM', 'Somalia', 'Somalie'),
(201, 710, 'ZA', 'ZAF', 'South Africa', 'Afrique du Sud'),
(202, 716, 'ZW', 'ZWE', 'Zimbabwe', 'Zimbabwe'),
(203, 724, 'ES', 'ESP', 'Spain', 'Espagne'),
(204, 732, 'EH', 'ESH', 'Western Sahara', 'Sahara Occidental'),
(205, 736, 'SD', 'SDN', 'Sudan', 'Soudan'),
(206, 740, 'SR', 'SUR', 'Suriname', 'Suriname'),
(207, 744, 'SJ', 'SJM', 'Svalbard and Jan Mayen', 'Svalbard etIle Jan Mayen'),
(208, 748, 'SZ', 'SWZ', 'Swaziland', 'Swaziland'),
(209, 752, 'SE', 'SWE', 'Sweden', 'Suede'),
(210, 756, 'CH', 'CHE', 'Switzerland', 'Suisse'),
(211, 760, 'SY', 'SYR', 'Syrian Arab Republic', 'Republique Arabe Syrienne'),
(212, 762, 'TJ', 'TJK', 'Tajikistan', 'Tadjikistan'),
(213, 764, 'TH', 'THA', 'Thailand', 'Thaïlande'),
(214, 768, 'TG', 'TGO', 'Togo', 'Togo'),
(215, 772, 'TK', 'TKL', 'Tokelau', 'Tokelau'),
(216, 776, 'TO', 'TON', 'Tonga', 'Tonga'),
(217, 780, 'TT', 'TTO', 'Trinidad and Tobago', 'Trinite-et-Tobago'),
(218, 784, 'AE', 'ARE', 'United Arab Emirates', 'Emirats Arabes Unis'),
(219, 788, 'TN', 'TUN', 'Tunisia', 'Tunisie'),
(220, 792, 'TR', 'TUR', 'Turkey', 'Turquie'),
(221, 795, 'TM', 'TKM', 'Turkmenistan', 'Turkmenistan'),
(222, 796, 'TC', 'TCA', 'Turks and Caicos Islands', 'Iles Turks et Caïques'),
(223, 798, 'TV', 'TUV', 'Tuvalu', 'Tuvalu'),
(224, 800, 'UG', 'UGA', 'Uganda', 'Ouganda'),
(225, 804, 'UA', 'UKR', 'Ukraine', 'Ukraine'),
(226, 807, 'MK', 'MKD', 'The Former Yugoslav Republic of Macedonia', 'L''ex-Republique Yougoslave de Macedoine'),
(227, 818, 'EG', 'EGY', 'Egypt', 'Egypte'),
(228, 826, 'GB', 'GBR', 'United Kingdom', 'Royaume-Uni'),
(229, 833, 'IM', 'IMN', 'Isle of Man', 'Ile de Man'),
(230, 834, 'TZ', 'TZA', 'United Republic Of Tanzania', 'Republique-Unie de Tanzanie'),
(231, 840, 'US', 'USA', 'United States', 'Etats-Unis'),
(232, 850, 'VI', 'VIR', 'U.S. Virgin Islands', 'Iles Vierges des Etats-Unis'),
(233, 854, 'BF', 'BFA', 'Burkina Faso', 'Burkina Faso'),
(234, 858, 'UY', 'URY', 'Uruguay', 'Uruguay'),
(235, 860, 'UZ', 'UZB', 'Uzbekistan', 'Ouzbekistan'),
(236, 862, 'VE', 'VEN', 'Venezuela', 'Venezuela'),
(237, 876, 'WF', 'WLF', 'Wallis and Futuna', 'Wallis et Futuna'),
(238, 882, 'WS', 'WSM', 'Samoa', 'Samoa'),
(239, 887, 'YE', 'YEM', 'Yemen', 'Yemen'),
(240, 891, 'CS', 'SCG', 'Serbia and Montenegro', 'Serbie-et-Montenegro'),
(241, 894, 'ZM', 'ZMB', 'Zambia', 'Zambie');

-- unite monetaire
insert into uniteMonetaire(unite) values ('Euro');
insert into uniteMonetaire(unite) values ('Dollar');
insert into uniteMonetaire(unite) values ('MGA');


-- qualite tiers
insert into qualiteTiers(qualite) values ('Classe A');
insert into qualiteTiers(qualite) values ('Classe B');
insert into qualiteTiers(qualite) values ('Classe C');

-- etats tiers
insert into etatTiers(etatTiers) values ('Actif');
insert into etatTiers(etatTiers) values ('Inactif');

insert into certificationClient(certification) values ('GOTS');
insert into certificationClient(certification) values ('OCS');
insert into certificationClient(certification) values ('ICS');
insert into certificationClient(certification) values ('BCI');

-- style
insert into style(nom_style,effectif,efficience,pointdev) values ('robe',33,0.5,2);
insert into style(nom_style,effectif,efficience,pointdev) values ('jupe',22,0.45,3);
insert into style(nom_style,effectif,efficience,pointdev) values ('tee-shirt',17,0.6,1);


-- incontern
insert into incontern(type_incontern) values ('FOB');
insert into incontern(type_incontern) values ('FAB');
insert into incontern(type_incontern) values ('FEB');

-- phase
insert into phase(type_phase) values ('demande de devis');
insert into phase(type_phase) values ('demande de cotation');
insert into phase(type_phase) values ('demande de devis et cotation');

-- saison
insert into saison(type_saison) values ('E24');
insert into saison(type_saison) values ('H24');
insert into saison(type_saison) values ('E25');

-- lavage
insert into lavage(type_lavage) values ('Simple');
insert into lavage(type_lavage) values ('Pousse');
insert into lavage(type_lavage) values ('Adoucissant');
insert into lavage(type_lavage) values ('Enzymatique');
insert into lavage(type_lavage) values ('Blanchissement');
insert into lavage(type_lavage) values ('Normal');

-- valeur ajoute
insert into valeurAjoutee(type_valeur_ajoutee) values ('Broderie main');
insert into valeurAjoutee(type_valeur_ajoutee) values ('Broderie machine');
insert into valeurAjoutee(type_valeur_ajoutee) values ('Serigraphie');
insert into valeurAjoutee(type_valeur_ajoutee) values ('Smock');

-- stade demande client
insert into stadeDemandeClient(type_stade) values ('Non alloue');
insert into stadeDemandeClient(type_stade) values ('TDS_2');
insert into stadeDemandeClient(type_stade) values ('TDS_3');
insert into stadeDemandeClient(type_stade) values ('PPS_1');
insert into stadeDemandeClient(type_stade) values ('PPS_2');
insert into stadeDemandeClient(type_stade) values ('PPS_3');
insert into stadeDemandeClient(type_stade) values ('PPS_4');
insert into stadeDemandeClient(type_stade) values ('CONFORMITE');
insert into stadeDemandeClient(type_stade) values ('PROD');
insert into stadeDemandeClient(type_stade) values ('Nego_1');
insert into stadeDemandeClient(type_stade) values ('Nego_2');
insert into stadeDemandeClient(type_stade) values ('Nego_3');
insert into stadeDemandeClient(type_stade) values ('Mock_up_TDS');
insert into stadeDemandeClient(type_stade) values ('PROTO_1');
insert into stadeDemandeClient(type_stade) values ('PROTO_2');
insert into stadeDemandeClient(type_stade) values ('PROTO_3');
insert into stadeDemandeClient(type_stade) values ('Mock_up_PPS');
insert into stadeDemandeClient(type_stade) values ('Mock_up_Proto');
insert into stadeDemandeClient(type_stade) values ('Shotting_TDS');
insert into stadeDemandeClient(type_stade) values ('Shotting_PPS');
insert into stadeDemandeClient(type_stade) values ('Shotting_Proto');
insert into stadeDemandeClient(type_stade) values ('SHIPMENT_SAMPLE');
insert into stadeDemandeClient(type_stade) values ('GARMENT_SAMPLE');

-- etat demande client
insert into etatDemandeClient(type_etat) values ('En cours de Nego');
insert into etatDemandeClient(type_etat) values ('Confirmée');
insert into etatDemandeClient(type_etat) values ('Annulée');

-- unite taille
insert into uniteTaille(unite_taille,rang) values ('1M',1);
insert into uniteTaille(unite_taille,rang) values ('2M',2);
insert into uniteTaille(unite_taille,rang) values ('3M',3);
insert into uniteTaille(unite_taille,rang) values ('4M',4);
insert into uniteTaille(unite_taille,rang) values ('5M',5);
insert into uniteTaille(unite_taille,rang) values ('6M',6);
insert into uniteTaille(unite_taille,rang) values ('7M',7);
insert into uniteTaille(unite_taille,rang) values ('8M',8);
insert into uniteTaille(unite_taille,rang) values ('9M',9);
insert into uniteTaille(unite_taille,rang) values ('10M',10);
insert into uniteTaille(unite_taille,rang) values ('1A',11);
insert into uniteTaille(unite_taille,rang) values ('2A',12);
insert into uniteTaille(unite_taille,rang) values ('3A',13);

-- type tissu
insert into typeTissus(type_tissus) values ('Tissus1');
insert into typeTissus(type_tissus) values ('Tissus2');
insert into typeTissus(type_tissus) values ('Tissus3');
insert into typeTissus(type_tissus) values ('Tissus4');

-- categorie tissu
insert into categorieTissus(categorie) values ('BIO');
insert into categorieTissus(categorie) values ('NON-BIO');

-- composition tissu
insert into compositionTissus(composition_tissus) values ('50% CO 50% LIN');
insert into compositionTissus(composition_tissus) values ('70% CO 30% LIN');

-- famille tissu
insert into familleTissus(famille_tissus) values ('Chaine et trame');
insert into familleTissus(famille_tissus) values ('maille');

-- unite de mesure matiere premiere
insert into uniteMesureMatierePremiere(unite_mesure) values ('m');
insert into uniteMesureMatierePremiere(unite_mesure) values ('pieces');
insert into uniteMesureMatierePremiere(unite_mesure) values ('cones');

-- classe matiere premiere
insert into classeMatierePremiere(classe) values ('en cours');
insert into classeMatierePremiere(classe) values ('current');

-- type accessoire
insert into typeAccessoire(type_accessoire) values ('Accessoire1');
insert into typeAccessoire(type_accessoire) values ('Accessoire2');
insert into typeAccessoire(type_accessoire) values ('Accessoire3');
insert into typeAccessoire(type_accessoire) values ('Accessoire4');
insert into typeAccessoire(type_accessoire) values ('Accessoire finition');

-- famille accessoire
insert into familleAccessoire(famille_accessoire) values ('boutton');
insert into familleAccessoire(famille_accessoire) values ('etiquette');
insert into familleAccessoire(famille_accessoire) values ('fermeture long');

-- disposition matiere premiere
insert into dispositionMatierePremiere(disposition) values ('Conforme');
insert into dispositionMatierePremiere(disposition) values ('Substitute');

-- caracteristique tissu
insert into caracteristiqueTissu(caracteristique,pointDev) VALUES ('Sens',1);
insert into caracteristiqueTissu(caracteristique,pointDev) VALUES ('Uni teint',2);
insert into caracteristiqueTissu(caracteristique,pointDev) VALUES ('Imprime',2);
insert into caracteristiqueTissu(caracteristique,pointDev) VALUES ('Carreaux',2);
insert into caracteristiqueTissu(caracteristique,pointDev) VALUES ('Rayure',1);
insert into caracteristiqueTissu(caracteristique,pointDev) VALUES ('Matching',2);
insert into caracteristiqueTissu(caracteristique,pointDev) VALUES ('Complexe',3);

insert into role(role) VALUES ('Admin');
insert into role(role) VALUES ('Visiteur');
insert into role(role) VALUES ('CRM');
insert into role(role) VALUES ('DEV');
insert into role(role) VALUES ('Planning');
insert into etapeDev(etape,niveau,duree) VALUES ('Bureau etude',1,2);
insert into etapeDev(etape,niveau,duree) VALUES ('Patronage',2,1);
insert into etapeDev(etape,niveau,duree) VALUES ('Placement',3,2);
insert into etapeDev(etape,niveau,duree) VALUES ('Controle patronage',4,2);
insert into etapeDev(etape,niveau,duree) VALUES ('Attente',5,2);
insert into etapeDev(etape,niveau,duree) VALUES ('Coupe',6,1);
insert into etapeDev(etape,niveau,duree) VALUES ('Brod main',7,1);
insert into etapeDev(etape,niveau,duree) VALUES ('Brod machine',8,1);
insert into etapeDev(etape,niveau,duree) VALUES ('Print',9,1);
insert into etapeDev(etape,niveau,duree) VALUES ('Teinture',10,1);
insert into etapeDev(etape,niveau,duree) VALUES ('Montage ',11,1);
insert into etapeDev(etape,niveau,duree) VALUES ('Finition',12,1);
insert into etapeDev(etape,niveau,duree) VALUES ('Controle final',13,1);
insert into etapeDev(etape,niveau,duree) VALUES ('Transmission',14,1);
insert into etapeDev(etape,niveau,duree) VALUES ('Envoie merch',15,1);
insert into etapeDev(etape,niveau,duree) VALUES ('Envoie client',16,1);

-- 12/09/2024
-- type patronage
insert into typePatronage(typePatron,pointDev) values ('creer',3);
insert into typePatronage(typePatron,pointDev) values ('modifier',1);
insert into typePatronage(typePatron,pointDev) values ('client',0);

-- fonction employe
insert into fonctionEmploye(designation) VALUES ('patronage');
insert into fonctionEmploye(designation) VALUES ('stagiaire projet');
insert into fonctionEmploye(designation) VALUES ('placeur');
insert into fonctionEmploye(designation) VALUES ('montage');
insert into fonctionEmploye(designation) VALUES ('commerciale');


-- section
insert into section(designation) VALUES ('Projet');
insert into section(designation) VALUES ('Developpement');
insert into section(designation) VALUES ('Methode');
insert into section(designation) VALUES ('Merch');

--  classification employe
insert into classification(designation) VALUES ('ClasseA');
insert into classification(designation) VALUES ('ClasseB');
insert into classification(designation) VALUES ('ClasseC');

-- liste employe
insert into listeEmploye(nom,prenom,matricule,idFonction,idSection,idClassification,idPays) values ('Rakoto','Benja','19022',1,2,2,1);
insert into listeEmploye(nom,prenom,matricule,idFonction,idSection,idClassification,idPays) values ('Olivier','Patrick','19023',1,2,2,1);
insert into listeEmploye(nom,prenom,matricule,idFonction,idSection,idClassification,idPays) values ('Rabe','Lova','19024',3,2,2,1);
insert into listeEmploye(nom,prenom,matricule,idFonction,idSection,idClassification,idPays) values ('Jean','Marcelle','19025',3,2,2,1);
insert into listeEmploye(nom,prenom,matricule,idFonction,idSection,idClassification,idPays) values ('Ravao','Lalao','19026',4,2,3,1);
insert into listeEmploye(nom,prenom,matricule,idFonction,idSection,idClassification,idPays) values ('Liva','Pascal','19027',4,2,3,1);
insert into listeEmploye(nom,prenom,matricule,idFonction,idSection,idClassification,idPays) values ('Bao','Juliette','19028',4,2,3,1);

insert into listeEmploye(nom,prenom,matricule,idFonction,idSection,idClassification,idPays,idrole,pseudo,motDePasse) values ('Sitraka','Mino','19030',5,4,3,1,3,'Mino','mino');
insert into listeEmploye(nom,prenom,matricule,idFonction,idSection,idClassification,idPays,idrole,pseudo,motDePasse) values ('Rakotobe','Tina','19029',5,4,3,1,3,'Tina','tina');

-- 18/09/2024
-- type occurence patronage
insert into typePlacement(typePlacement,pointPlacement) values ('combine',1);
insert into typePlacement(typePlacement,pointPlacement) values ('normal',3);
insert into typePlacement(typePlacement,pointPlacement) values ('raccordee',2);
insert into typeOccurencePatronage(occurence) VALUES ('Occ1');
insert into typeOccurencePatronage(occurence) VALUES ('Occ2');
insert into typeOccurencePatronage(occurence) VALUES ('Occ3');

INSERT INTO heureTravailEmployee (idListeEmploye, dateEntree, dateSortie)
VALUES
(1, '2024-09-23 08:00:00', '2024-09-23 16:00:00'),
(2, '2024-09-23 09:00:00', '2024-09-23 17:30:00'),
(3, '2024-09-23 07:45:00', '2024-09-23 15:45:00'),
(4, '2024-09-24 08:30:00', '2024-09-24 16:30:00'),
(5, '2024-09-24 08:15:00', '2024-09-24 17:15:00');

insert into typeRetouche(typeRetouche) VALUES ('Retouche1');
insert into typeRetouche(typeRetouche) VALUES ('Retouche2');
insert into typeRetouche(typeRetouche) VALUES ('Retouche3');
insert into typeRetouche(typeRetouche) VALUES ('Retouche4');

insert into periode(periode) VALUES ('P1');
insert into periode(periode) VALUES ('P2');
insert into periode(periode) VALUES ('P3');

-- sarobidy

INSERT INTO leadtime (designation,leadtime,etat)VALUES
('matiere p',20,0),
('echantillon',14,0),
('production',40,0);

insert into stadeMasterPlan(designation,niveau) values ('NEGOCIATION', 0);
insert into stadeMasterPlan(designation,niveau) values ('APPROVISIONNEMENT', 1);
insert into stadeMasterPlan(designation,niveau) values ('TRANSFORMATION', 2);
insert into stadeMasterPlan(designation,niveau) values ('CONDITIONNEMENT', 3);

insert into stadeSpecifique(idStadeMasterPlan, designation, niveau) values (1, 'RECEPTION COMMANDE', 0);
insert into stadeSpecifique(idStadeMasterPlan, designation, niveau) values (1, 'ECHANTILLON', 1);
insert into stadeSpecifique(idStadeMasterPlan, designation, niveau) values (1, 'PRI', 2);
insert into stadeSpecifique(idStadeMasterPlan, designation, niveau) values (1, 'FINI ECHANTILLON', 3);
insert into stadeSpecifique(idStadeMasterPlan, designation, niveau) values (1, 'FINI PRI', 4);
insert into stadeSpecifique(idStadeMasterPlan, designation, niveau) values (1, 'VALIDE', 5);

insert into stadeSpecifique(idStadeMasterPlan, designation, niveau) values (2, 'BC TISSU', 0);
insert into stadeSpecifique(idStadeMasterPlan, designation, niveau) values (2, 'BC ACCESSOIRE', 1);
insert into stadeSpecifique(idStadeMasterPlan, designation, niveau) values (2, 'ENVOYE DEV', 2);
insert into stadeSpecifique(idStadeMasterPlan, designation, niveau) values (2, 'RECEP MAGASIN', 3);
insert into stadeSpecifique(idStadeMasterPlan, designation, niveau) values (2, 'OK PROD', 4);

insert into stadeSpecifique(idStadeMasterPlan, designation, niveau) values (3, 'TEINTURE', 0);
insert into stadeSpecifique(idStadeMasterPlan, designation, niveau) values (3, 'COUPE', 1);
insert into stadeSpecifique(idStadeMasterPlan, designation, niveau) values (3, 'PRINT', 2);
insert into stadeSpecifique(idStadeMasterPlan, designation, niveau) values (3, 'BROD MACHINE', 3);
insert into stadeSpecifique(idStadeMasterPlan, designation, niveau) values (3, 'BROD MAIN', 4);
insert into stadeSpecifique(idStadeMasterPlan, designation, niveau) values (3, 'MONTAGE', 5);
insert into stadeSpecifique(idStadeMasterPlan, designation, niveau) values (3, 'LAVAGE', 6);
insert into stadeSpecifique(idStadeMasterPlan, designation, niveau) values (3, 'REPASSAGE', 7);

insert into stadeSpecifique(idStadeMasterPlan, designation, niveau) values (4, 'CONDITIONNEMENT', 0);
insert into stadeSpecifique(idStadeMasterPlan, designation, niveau) values (4, 'BOXING', 1);
insert into stadeSpecifique(idStadeMasterPlan, designation, niveau) values (4, 'INSPECTION', 2);
insert into stadeSpecifique(idStadeMasterPlan, designation, niveau) values (4, 'EXPEDITION', 3);
insert into stadeSpecifique(idStadeMasterPlan, designation, niveau) values (4, 'FACTURATION', 4);
-------------------RAD------------

-------------------DATA & MACRO------------
INSERT INTO localisationMachine (localisation, etat)
VALUES ('Warehouse A', 1),
       ('Factory Floor 1', 1),
       ('Maintenance Room', 0);

INSERT INTO secteurMachine (idLocalisationMachine, secteur, etat)
VALUES (1, 'Textile Division', 1),
       (2, 'Assembly Line 3', 1),
       (3, 'Quality Control', 0);

INSERT INTO marqueMachine (marque, etat)
VALUES ('BrandX', 1),
       ('MachCorp', 1),
       ('TurboTech', 0);

INSERT INTO categorieMachine (categorie, etat)
VALUES ('Loom Machine', 1),
       ('Cutting Machine', 1),
       ('Sewing Machine', 0);

INSERT INTO etatMachine (etatMachine, etat)
VALUES ('Operational', 1),
       ('Under Maintenance', 1),
       ('Out of Order', 0);

------Mbola tsy mandeha----
INSERT INTO listeMachine (idMarqueMachine, dateEntreeMachine, codeMachine, idCategorieMachine, photoMachine, id_Tiers_f_machine, PrixU, idUniteMonetaire, idEtatMachine, reference, proprietee, prixPrestation, dateSortie, idUnitemesure, capacite, etat)
VALUES (1, '2023-05-10', 'MCH001', 1, 'machine1.jpg', 2, 15000.00, 1, 1, 'REFMACH001', true, 500.00, '2024-01-01', 1, 200, 1),
       (2, '2022-12-01', 'MCH002', 2, 'machine2.jpg', 2, 23000.00, 2, 2, 'REFMACH002', false, 700.00, '2024-01-01', 2, 350, 1),
       (3, '2021-08-15', 'MCH003', 3, 'machine3.jpg', 2, 18000.00, 1, 3, 'REFMACH003', true, 0.00, '2024-01-01', 3, 150, 0);


-- Insertion dans la table conformite
INSERT INTO conformite (designation, etat) VALUES
('BIO', 0),
('NON-BIO', 0),
('ORGANIC', 0);

insert into type_bc values(default,'Tissu',0);
insert into type_bc values(default,'Accessoire',0);
insert into type_bc values(default,'Coupe Type',0);
insert into type_bc values(default,'General',0);



-- Insertion dans la table chaine (16 chaînes, pas de chaîne 13)
INSERT INTO chaine (designation, idConformite, etat) VALUES
('Chaine 1', 1, 0),
('Chaine 2', 2, 0),
('Chaine 3', 1, 0),
('Chaine 4', 3, 0),
('Chaine 5', 2, 0),
('Chaine 6', 1, 0),
('Chaine 7', 3, 0),
('Chaine 8', 2, 0),
('Chaine 9', 1, 0),
('Chaine 10', 3, 0),
('Chaine 11', 2, 0),
('Chaine 12', 1, 0),
('Chaine 14', 3, 0),
('Chaine 15', 2, 0),
('Chaine 16', 1, 0);

-- Insertion dans la table specialiteChaine (liens entre les chaînes et des styles)
INSERT INTO specialiteChaine (id_chaine, id_style, etat) VALUES
(1, 1, 0),
(2, 3, 0),
(3, 2, 0),
(4, 3, 0),
(5, 3, 0),
(6, 1, 0),
(7, 2, 0),
(8, 3, 0),
(9, 1, 0),
(10, 3, 0),
(11, 1, 0),
(12, 3, 0),
(13, 2, 0),
(14, 2, 0),
(15, 1, 0);

-- jours fériés
INSERT INTO jours_feries (jour, mois) VALUES (1, 1);  -- 01-01
INSERT INTO jours_feries (jour, mois) VALUES (8, 3);  -- 08-03
INSERT INTO jours_feries (jour, mois) VALUES (29, 3); -- 29-03
INSERT INTO jours_feries (jour, mois) VALUES (20, 4); -- 20-04
INSERT INTO jours_feries (jour, mois) VALUES (21, 4); -- 21-04
INSERT INTO jours_feries (jour, mois) VALUES (1, 5);  -- 01-05
INSERT INTO jours_feries (jour, mois) VALUES (25, 5); -- 25-05
INSERT INTO jours_feries (jour, mois) VALUES (29, 5); -- 29-05
INSERT INTO jours_feries (jour, mois) VALUES (8, 6);  -- 08-06
INSERT INTO jours_feries (jour, mois) VALUES (9, 6);  -- 09-06
INSERT INTO jours_feries (jour, mois) VALUES (15, 6); -- 15-06
INSERT INTO jours_feries (jour, mois) VALUES (26, 6); -- 26-06
INSERT INTO jours_feries (jour, mois) VALUES (15, 8); -- 15-08
INSERT INTO jours_feries (jour, mois) VALUES (1, 11); -- 01-11
INSERT INTO jours_feries (jour, mois) VALUES (25, 12); -- 25-12
-------------------DATA & MACRO------------

INSERT INTO etapeRetroMerch(id, designation , stade , etat ,nbjour ,etape_quantite) VALUES (DEFAULT, 'DISPO TISS & ACCY', 'PROTO1', 0, 5, 10);
INSERT INTO etapeRetroMerch(id, designation , stade , etat ,nbjour ,etape_quantite) VALUES (DEFAULT, 'ENVOI SDC', 'PROTO1', 0, 10, 10);
INSERT INTO etapeRetroMerch(id, designation , stade , etat ,nbjour ,etape_quantite) VALUES (DEFAULT, 'FIN MONTAGE', 'PROTO1', 0, 2, 10);
INSERT INTO etapeRetroMerch(id, designation , stade , etat ,nbjour ,etape_quantite) VALUES (DEFAULT, 'ENVOI PROTO', 'PROTO1', 0, 10, 10);
INSERT INTO etapeRetroMerch(id, designation , stade , etat ,nbjour ,etape_quantite) VALUES (DEFAULT, 'COMMENTAIRE PROTO', 'PROTO1', 0, 7, 10);

-- Insert for stage 'PROTO2' with etape_quantite as the last column
INSERT INTO etapeRetroMerch(id, designation , stade , etat ,nbjour ,etape_quantite) VALUES (DEFAULT, 'DISPO TISS & ACCY', 'PROTO2', 0, 5, 12);
INSERT INTO etapeRetroMerch(id, designation , stade , etat ,nbjour ,etape_quantite) VALUES (DEFAULT, 'ENVOI SDC', 'PROTO2', 0, 10, 12);
INSERT INTO etapeRetroMerch(id, designation , stade , etat ,nbjour ,etape_quantite) VALUES (DEFAULT, 'FIN MONTAGE', 'PROTO2', 0, 2, 12);
INSERT INTO etapeRetroMerch(id, designation , stade , etat ,nbjour ,etape_quantite) VALUES (DEFAULT, 'ENVOI PROTO', 'PROTO2', 0, 10, 12);
INSERT INTO etapeRetroMerch(id, designation , stade , etat ,nbjour ,etape_quantite) VALUES (DEFAULT, 'COMMENTAIRE PROTO', 'PROTO2', 0, 4, 12);

-- Insert for stage 'TDS1' with etape_quantite as the last column
INSERT INTO etapeRetroMerch(id, designation , stade , etat ,nbjour ,etape_quantite) VALUES (DEFAULT, 'DISPO TISS & ACCY', 'TDS1', 0, 3, 15);
INSERT INTO etapeRetroMerch(id, designation , stade , etat ,nbjour ,etape_quantite) VALUES (DEFAULT, 'ENVOI SDC', 'TDS1', 0, 10, 15);
INSERT INTO etapeRetroMerch(id, designation , stade , etat ,nbjour ,etape_quantite) VALUES (DEFAULT, 'FIN MONTAGE', 'TDS1', 0, 2, 15);
INSERT INTO etapeRetroMerch(id, designation , stade , etat ,nbjour ,etape_quantite) VALUES (DEFAULT, 'ENVOI PROTO', 'TDS1', 0, 10, 15);
INSERT INTO etapeRetroMerch(id, designation , stade , etat ,nbjour ,etape_quantite) VALUES (DEFAULT, 'COMMENTAIRE PROTO', 'TDS1', 0, 4, 15);

-- Insert for stage 'TDS2' with etape_quantite as the last column
INSERT INTO etapeRetroMerch(id, designation , stade , etat ,nbjour ,etape_quantite) VALUES (DEFAULT, 'DISPO TISS & ACCY', 'TDS2', 0, 5, 20);
INSERT INTO etapeRetroMerch(id, designation , stade , etat ,nbjour ,etape_quantite) VALUES (DEFAULT, 'ENVOI SDC', 'TDS2', 0, 10, 20);
INSERT INTO etapeRetroMerch(id, designation , stade , etat ,nbjour ,etape_quantite) VALUES (DEFAULT, 'FIN MONTAGE', 'TDS2', 0, 2, 20);
INSERT INTO etapeRetroMerch(id, designation , stade , etat ,nbjour ,etape_quantite) VALUES (DEFAULT, 'ENVOI PROTO', 'TDS2', 0, 10, 20);
INSERT INTO etapeRetroMerch(id, designation , stade , etat ,nbjour ,etape_quantite) VALUES (DEFAULT, 'COMMENTAIRE PROTO', 'TDS2', 0, 4, 20);

-- Insert for stage 'PPS1' with etape_quantite as the last column
INSERT INTO etapeRetroMerch(id, designation , stade , etat ,nbjour ,etape_quantite) VALUES (DEFAULT, 'DISPO TISS & ACCY', 'PPS1', 0, 5, 18);
INSERT INTO etapeRetroMerch(id, designation , stade , etat ,nbjour ,etape_quantite) VALUES (DEFAULT, 'ENVOI SDC', 'PPS1', 0, 10, 18);
INSERT INTO etapeRetroMerch(id, designation , stade , etat ,nbjour ,etape_quantite) VALUES (DEFAULT, 'FIN MONTAGE', 'PPS1', 0, 2, 18);
INSERT INTO etapeRetroMerch(id, designation , stade , etat ,nbjour ,etape_quantite) VALUES (DEFAULT, 'ENVOI PROTO', 'PPS1', 0, 10, 18);
INSERT INTO etapeRetroMerch(id, designation , stade , etat ,nbjour ,etape_quantite) VALUES (DEFAULT, 'COMMENTAIRE PROTO', 'PPS1', 0, 4, 18);

-- Insert for stage 'PPS2' with etape_quantite as the last column
INSERT INTO etapeRetroMerch(id, designation , stade , etat ,nbjour ,etape_quantite) VALUES (DEFAULT, 'DISPO TISS & ACCY', 'PPS2', 0, 5, 22);
INSERT INTO etapeRetroMerch(id, designation , stade , etat ,nbjour ,etape_quantite) VALUES (DEFAULT, 'ENVOI SDC', 'PPS2', 0, 10, 22);
INSERT INTO etapeRetroMerch(id, designation , stade , etat ,nbjour ,etape_quantite) VALUES (DEFAULT, 'FIN MONTAGE', 'PPS2', 0, 2, 22);
INSERT INTO etapeRetroMerch(id, designation , stade , etat ,nbjour ,etape_quantite) VALUES (DEFAULT, 'ENVOI PROTO', 'PPS2', 0, 10, 22);
INSERT INTO etapeRetroMerch(id, designation , stade , etat ,nbjour ,etape_quantite) VALUES (DEFAULT, 'COMMENTAIRE PROTO', 'PPS2', 0, 4, 22);

-- Insert for retro steps without specific stage, with etape_quantite as the last column
INSERT INTO etapeRetroMerch(id, designation , stade , etat ,nbjour ,etape_quantite) VALUES (DEFAULT, 'DATE OK TECH', '', 0, 10, 25);
INSERT INTO etapeRetroMerch(id, designation , stade , etat ,nbjour ,etape_quantite) VALUES (DEFAULT, 'DATE LCMT TRACE', '', 0, 2, 25);
INSERT INTO etapeRetroMerch(id, designation , stade , etat ,nbjour ,etape_quantite) VALUES (DEFAULT, 'DATE OK PROD', '', 0, 10, 25);
INSERT INTO etapeRetroMerch(id, designation , stade , etat ,nbjour ,etape_quantite) VALUES (DEFAULT, 'DATE GARMENT', '', 0, 4, 25);
INSERT INTO etapeRetroMerch(id, designation , stade , etat ,nbjour ,etape_quantite) VALUES (DEFAULT, 'DATE SHIPMENT', '', 0, 10, 25);
INSERT INTO etapeRetroMerch(id, designation , stade , etat ,nbjour ,etape_quantite) VALUES (DEFAULT, 'DATE SHOOTING', '', 0, 2, 25);
INSERT INTO etapeRetroMerch(id, designation , stade , etat ,nbjour ,etape_quantite) VALUES (DEFAULT, 'DATE MOCK UP', '', 0, 10, 25);
INSERT INTO etapeRetroMerch(id, designation , stade , etat ,nbjour ,etape_quantite) VALUES (DEFAULT, 'DATE CONFORMITE', '', 0, 4, 25);
-- eta BC
insert into etatbc(etatbc) VALUES ('Non recu');
insert into etatbc(etatbc) VALUES ('Recu partielle');
insert into etatbc(etatbc) VALUES ('Recu 100%');
insert into etatbc(etatbc) VALUES ('Retard');
insert into etatbc(etatbc) VALUES ('Reclamation');
insert into etatbc(etatbc) VALUES ('Non Payer');
insert into etatbc(etatbc) VALUES ('Payer partielle');
insert into etatbc(etatbc) VALUES ('Payer 100%');



insert into destStd values(default,'destignation1',0);
insert into destStd values(default,'destignation2',0);
insert into destStd values(default,'destignation3',0);
insert into destStd values(default,'destignation4',0);


insert into etatRetroMerch(etatRetroMerch) VALUES ('MP Non Dispo');
insert into etatRetroMerch(etatRetroMerch) VALUES ('Attente SDC');
insert into etatRetroMerch(etatRetroMerch) VALUES ('Retard');
insert into etatRetroMerch(etatRetroMerch) VALUES ('OK Prod');
