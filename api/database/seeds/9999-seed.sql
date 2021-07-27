--
-- PostgreSQL database dump
--

-- Dumped from database version 12.7 (Debian 12.7-1.pgdg100+1)
-- Dumped by pg_dump version 13.3

-- These are settings generated during the database dump

--SET statement_timeout = 0;
--SET lock_timeout = 0;
--SET idle_in_transaction_session_timeout = 0;
--SET client_encoding = 'UTF8';
--SET standard_conforming_strings = on;
--SELECT pg_catalog.set_config('search_path', '', false);
--SET check_function_bodies = false;
--SET xmloption = content;
--SET client_min_messages = warning;
--SET row_security = off;

--
-- Data for Name: accounts; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.accounts (id, uid, name, password, balance, active, created_at, updated_at, print, inactive_since) VALUES (1, '8aa25196-c189-35f2-90f3-3fcd618f77c3', 'Rylee', '', 5541, true, '2021-07-06 14:36:11', '2021-07-06 14:36:11', true, NULL);
INSERT INTO public.accounts (id, uid, name, password, balance, active, created_at, updated_at, print, inactive_since) VALUES (2, '7b1f42f1-07cc-343b-b371-d95b99346a00', 'Jett', '', 1986, false, '2021-07-06 14:36:11', '2021-07-06 14:36:11', true, NULL);
INSERT INTO public.accounts (id, uid, name, password, balance, active, created_at, updated_at, print, inactive_since) VALUES (3, 'f6d37654-7bbc-31d5-b47b-97814162075e', 'Allan', '', 9008, true, '2021-07-06 14:36:11', '2021-07-06 14:36:11', true, NULL);
INSERT INTO public.accounts (id, uid, name, password, balance, active, created_at, updated_at, print, inactive_since) VALUES (4, '0afabad3-97c6-366a-881b-ad914e414310', 'Wyatt', '', 3862, false, '2021-07-06 14:36:11', '2021-07-06 14:36:11', true, NULL);
INSERT INTO public.accounts (id, uid, name, password, balance, active, created_at, updated_at, print, inactive_since) VALUES (5, 'fc0c916f-a80e-39e6-8eb7-9680a5755c4d', 'Rae', '', 413, true, '2021-07-06 14:36:11', '2021-07-06 14:36:11', true, NULL);


--
-- Data for Name: active_years; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.active_years (id, year, description, group_photo, front_image, christmas_image, background_image, created_at, updated_at) VALUES (1, '2016-05-01', 'Det är vi som var HD', NULL, NULL, NULL, NULL, '2020-01-03 14:36:11', '2020-01-03 14:36:11');
INSERT INTO public.active_years (id, year, description, group_photo, front_image, christmas_image, background_image, created_at, updated_at) VALUES (2, '2021-05-01', 'Det är vi som är HD', NULL, NULL, NULL, NULL, '2021-07-06 14:36:11', '2021-07-06 14:36:11');

--
-- Data for Name: categories; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.categories (id, name, created_at, updated_at) VALUES (1, 'Abernathy Group', '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.categories (id, name, created_at, updated_at) VALUES (2, 'White, Howe and Osinski', '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.categories (id, name, created_at, updated_at) VALUES (3, 'Wolff, Bosco and Hilpert', '2021-07-06 14:36:11', '2021-07-06 14:36:11');


--
-- Data for Name: products; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (1, 1, 'kuvalis.liza', 41300, 0, 600, true, false, 1, '2021-07-06 14:36:11', '2021-07-06 14:36:11', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (2, 1, 'lon71', 376300, 0, 4800, true, false, 1, '2021-07-06 14:36:11', '2021-07-06 14:36:11', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (3, 1, 'rosalee.will', 236000, 0, 3000, true, false, 1, '2021-07-06 14:36:11', '2021-07-06 14:36:11', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (4, 1, 'hyatt.abbigail', 103600, 0, 1300, true, false, 1, '2021-07-06 14:36:11', '2021-07-06 14:36:11', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (5, 1, 'klocko.destany', 379900, 0, 4800, true, false, 1, '2021-07-06 14:36:11', '2021-07-06 14:36:11', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (6, 1, 'mcdermott.theron', 103100, 0, 1300, true, false, 1, '2021-07-06 14:36:11', '2021-07-06 14:36:11', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (7, 1, 'fromaguera', 851000, 0, 10700, true, false, 1, '2021-07-06 14:36:11', '2021-07-06 14:36:11', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (8, 1, 'wisozk.haskell', 459400, 0, 5800, true, false, 1, '2021-07-06 14:36:11', '2021-07-06 14:36:11', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (9, 1, 'renner.meghan', 155800, 0, 2000, true, false, 1, '2021-07-06 14:36:11', '2021-07-06 14:36:11', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (10, 1, 'okon.stacy', 32300, 0, 500, true, false, 1, '2021-07-06 14:36:11', '2021-07-06 14:36:11', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (11, 1, 'hoeger.amani', 749900, 0, 9400, true, false, 1, '2021-07-06 14:36:11', '2021-07-06 14:36:11', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (12, 1, 'zwisozk', 490400, 0, 6200, true, false, 1, '2021-07-06 14:36:11', '2021-07-06 14:36:11', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (13, 1, 'lavinia01', 387100, 0, 4900, true, false, 1, '2021-07-06 14:36:11', '2021-07-06 14:36:11', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (14, 1, 'rippin.gust', 710300, 0, 8900, true, false, 1, '2021-07-06 14:36:11', '2021-07-06 14:36:11', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (15, 1, 'hickle.kaela', 705800, 0, 8900, true, false, 1, '2021-07-06 14:36:11', '2021-07-06 14:36:11', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (16, 1, 'istanton', 804400, 118, 10000, true, false, 1, '2021-07-06 14:36:11', '2021-07-06 14:36:11', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (17, 1, 'stroman.anna', 123600, 0, 1600, true, false, 1, '2021-07-06 14:36:11', '2021-07-06 14:36:11', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (18, 1, 'eldred.kulas', 431800, 428, 4900, true, false, 1, '2021-07-06 14:36:11', '2021-07-06 14:36:11', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (19, 1, 'emerson.baumbach', 820800, 0, 10300, true, false, 1, '2021-07-06 14:36:11', '2021-07-06 14:36:11', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (20, 1, 'icorwin', 609800, 0, 7700, true, false, 1, '2021-07-06 14:36:11', '2021-07-06 14:36:11', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (21, 1, 'reichel.kylie', 773800, 869, 8600, true, false, 1, '2021-07-06 14:36:11', '2021-07-06 14:36:11', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (22, 1, 'yvonne.okeefe', 633600, 0, 8000, true, false, 1, '2021-07-06 14:36:11', '2021-07-06 14:36:11', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (23, 1, 'halvorson.gonzalo', 240600, 0, 3100, true, false, 1, '2021-07-06 14:36:11', '2021-07-06 14:36:11', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (24, 1, 'muller.leone', 148600, 297, 1500, true, false, 1, '2021-07-06 14:36:11', '2021-07-06 14:36:11', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (25, 1, 'qkub', 611800, 0, 7700, true, false, 1, '2021-07-06 14:36:11', '2021-07-06 14:36:11', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (26, 1, 'randy17', 66100, 0, 900, true, false, 1, '2021-07-06 14:36:11', '2021-07-06 14:36:11', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (27, 1, 'madelynn.sporer', 801600, 0, 10100, true, false, 1, '2021-07-06 14:36:11', '2021-07-06 14:36:11', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (28, 1, 'brock58', 552100, 0, 7000, true, false, 1, '2021-07-06 14:36:11', '2021-07-06 14:36:11', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (29, 1, 'trantow.kirsten', 822400, 0, 10300, true, false, 1, '2021-07-06 14:36:11', '2021-07-06 14:36:11', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (30, 1, 'florida95', 307100, 0, 3900, true, false, 1, '2021-07-06 14:36:11', '2021-07-06 14:36:11', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (31, 2, 'bahringer.lue', 492500, 0, 6200, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (32, 2, 'yost.scotty', 896900, 258, 10900, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (33, 2, 'candelario.johnson', 414400, 63, 5200, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (34, 2, 'reva57', 215700, 518, 2100, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (35, 2, 'maritza02', 832500, 744, 9500, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (36, 2, 'ressie.kreiger', 104900, 0, 1400, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (37, 2, 'stefanie42', 227900, 111, 2800, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (38, 2, 'iullrich', 42800, 0, 600, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (39, 2, 'west.kamille', 887200, 0, 11100, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (40, 2, 'halvorson.marcia', 769100, 0, 9700, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (41, 2, 'dkunze', 626200, 362, 7400, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (42, 2, 'brycen.leannon', 766500, 0, 9600, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (43, 2, 'marcelo.crist', 77500, 0, 1000, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (44, 2, 'jerel.ortiz', 901800, 0, 11300, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (45, 2, 'haven.fahey', 739700, 0, 9300, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (46, 2, 'kdibbert', 863500, 0, 10800, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (47, 2, 'uschaefer', 335000, 0, 4200, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (48, 2, 'lori.wilkinson', 873800, 0, 11000, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (49, 2, 'verlie.gorczany', 791700, 563, 9200, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (50, 2, 'madeline14', 108000, 396, 900, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (51, 2, 'quinn.hirthe', 416000, 0, 5200, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (52, 2, 'howell59', 128500, 0, 1700, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (53, 2, 'lschulist', 146200, 900, 800, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (54, 2, 'leonel43', 376400, 0, 4800, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (55, 2, 'leilani.zboncak', 401400, 312, 4700, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (56, 2, 'flatley.elvis', 117200, 851, 500, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (57, 2, 'reinger.juston', 63100, 591, 100, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (58, 2, 'alene42', 103000, 0, 1300, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (59, 2, 'tamara07', 970900, 0, 12200, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (60, 2, 'yhoppe', 691900, 0, 8700, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (61, 3, 'diamond.marvin', 666500, 0, 8400, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (62, 3, 'xbecker', 696500, 866, 7700, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (63, 3, 'weber.monserrat', 323000, 0, 4100, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (64, 3, 'gmorar', 635900, 0, 8000, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (65, 3, 'jacobson.frank', 844400, 0, 10600, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (66, 3, 'nellie.quitzon', 145800, 540, 1200, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (67, 3, 'rmccullough', 352600, 0, 4500, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (68, 3, 'raleigh38', 518100, 0, 6500, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (69, 3, 'queen.bernier', 355000, 611, 3700, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (70, 3, 'eva56', 77700, 0, 1000, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (71, 3, 'balistreri.leo', 236900, 0, 3000, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (72, 3, 'schamberger.richmond', 738800, 0, 9300, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (73, 3, 'adrain.hodkiewicz', 167300, 340, 1700, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (74, 3, 'destinee76', 349600, 0, 4400, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (75, 3, 'tanner81', 884300, 0, 11100, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (76, 3, 'clovis.rau', 815300, 0, 10200, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (77, 3, 'dillan26', 920100, 0, 11600, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (78, 3, 'trace.hills', 6400, 0, 100, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (79, 3, 'jamal.gleichner', 479800, 0, 6000, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (80, 3, 'lzboncak', 701900, 0, 8800, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (81, 3, 'wzieme', 771900, 0, 9700, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (82, 3, 'calista39', 187700, 0, 2400, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (83, 3, 'amalia58', 259600, 0, 3300, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (84, 3, 'kwisoky', 67900, 901, -200, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (85, 3, 'whand', 793300, 0, 10000, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (86, 3, 'josephine.ondricka', 254700, 0, 3200, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (87, 3, 'usawayn', 684500, 0, 8600, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (88, 3, 'jovanny.schiller', 462400, 0, 5800, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (89, 3, 'kulas.graciela', 658200, 435, 7700, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);
INSERT INTO public.products (id, category_id, name, purchase_price, discount, price, active, pant, package_size, created_at, updated_at, adjustment) VALUES (90, 3, 'orin21', 310100, 0, 3900, true, false, 1, '2021-07-06 14:36:12', '2021-07-06 14:36:12', 0);


--
-- Data for Name: barcodes; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (1, 1, NULL, '67596041', '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (2, 1, NULL, '94811599', '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (3, 2, NULL, '71737409', '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (4, 2, NULL, '09688421', '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (5, 3, NULL, '60221742', '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (6, 3, NULL, '39023155', '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (7, 4, NULL, '77367815', '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (8, 4, NULL, '61420953', '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (9, 5, NULL, '38128516', '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (10, 5, NULL, '65370575', '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (11, 6, NULL, '34354834', '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (12, 6, NULL, '17491389', '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (13, 7, NULL, '73957508', '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (14, 7, NULL, '01947090', '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (15, 8, NULL, '22272959', '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (16, 8, NULL, '58248560', '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (17, 9, NULL, '77939630', '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (18, 9, NULL, '97551188', '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (19, 10, NULL, '50787708', '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (20, 10, NULL, '99586577', '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (21, 11, NULL, '25317763', '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (22, 11, NULL, '21109720', '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (23, 12, NULL, '50915651', '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (24, 12, NULL, '95335919', '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (25, 13, NULL, '65128381', '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (26, 13, NULL, '53010766', '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (27, 14, NULL, '32090468', '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (28, 14, NULL, '59670988', '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (29, 15, NULL, '12012428', '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (30, 15, NULL, '61440715', '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (31, 16, NULL, '11168461', '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (32, 16, NULL, '22014399', '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (33, 17, NULL, '51141523', '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (34, 17, NULL, '40747293', '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (35, 18, NULL, '42577423', '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (36, 18, NULL, '78213760', '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (37, 19, NULL, '84870292', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (38, 19, NULL, '94623741', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (39, 20, NULL, '23268500', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (40, 20, NULL, '43927463', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (41, 21, NULL, '67384525', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (42, 21, NULL, '39120564', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (43, 22, NULL, '40058801', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (44, 22, NULL, '63030853', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (45, 23, NULL, '07084690', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (46, 23, NULL, '94927542', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (47, 24, NULL, '43409143', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (48, 24, NULL, '78515949', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (49, 25, NULL, '30712478', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (50, 25, NULL, '72617724', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (51, 26, NULL, '69778971', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (52, 26, NULL, '81442027', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (53, 27, NULL, '39835567', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (54, 27, NULL, '84992673', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (55, 28, NULL, '60581235', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (56, 28, NULL, '57435008', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (57, 29, NULL, '18808155', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (58, 29, NULL, '52074707', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (59, 30, NULL, '19932057', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (60, 30, NULL, '82819569', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (61, 31, NULL, '64587479', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (62, 31, NULL, '38683626', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (63, 32, NULL, '75226343', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (64, 32, NULL, '83843327', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (65, 33, NULL, '98240517', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (66, 33, NULL, '13418250', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (67, 34, NULL, '03369012', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (68, 34, NULL, '33411477', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (69, 35, NULL, '02117768', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (70, 35, NULL, '25064315', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (71, 36, NULL, '97573036', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (72, 36, NULL, '14606229', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (73, 37, NULL, '36070442', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (74, 37, NULL, '83050107', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (75, 38, NULL, '08694775', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (76, 38, NULL, '27745014', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (77, 39, NULL, '80739456', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (78, 39, NULL, '84786654', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (79, 40, NULL, '68630881', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (80, 40, NULL, '77111944', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (81, 41, NULL, '02767802', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (82, 41, NULL, '39055026', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (83, 42, NULL, '74064106', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (84, 42, NULL, '79427784', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (85, 43, NULL, '78328082', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (86, 43, NULL, '99173913', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (87, 44, NULL, '92313354', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (88, 44, NULL, '26865386', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (89, 45, NULL, '24495530', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (90, 45, NULL, '27844809', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (91, 46, NULL, '75136154', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (92, 46, NULL, '30854321', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (93, 47, NULL, '98349814', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (94, 47, NULL, '37559090', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (95, 48, NULL, '59019213', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (96, 48, NULL, '41946671', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (97, 49, NULL, '65832332', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (98, 49, NULL, '33894317', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (99, 50, NULL, '93336987', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (100, 50, NULL, '00828598', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (101, 51, NULL, '53310613', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (102, 51, NULL, '97294399', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (103, 52, NULL, '83379864', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (104, 52, NULL, '05041268', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (105, 53, NULL, '43055937', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (106, 53, NULL, '72751411', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (107, 54, NULL, '12037438', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (108, 54, NULL, '93514286', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (109, 55, NULL, '70476408', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (110, 55, NULL, '18413526', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (111, 56, NULL, '20578718', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (112, 56, NULL, '16523906', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (113, 57, NULL, '61760172', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (114, 57, NULL, '95927022', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (115, 58, NULL, '75258375', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (116, 58, NULL, '04473183', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (117, 59, NULL, '46547965', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (118, 59, NULL, '05020379', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (119, 60, NULL, '55242813', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (120, 60, NULL, '87063417', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (121, 61, NULL, '04717232', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (122, 61, NULL, '59886679', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (123, 62, NULL, '77207388', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (124, 62, NULL, '28825555', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (125, 63, NULL, '96739358', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (126, 63, NULL, '17841344', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (127, 64, NULL, '87720884', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (128, 64, NULL, '50618071', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (129, 65, NULL, '39156020', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (130, 65, NULL, '60361622', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (131, 66, NULL, '37694609', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (132, 66, NULL, '28851004', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (133, 67, NULL, '92323445', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (134, 67, NULL, '13687014', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (135, 68, NULL, '86351362', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (136, 68, NULL, '71320083', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (137, 69, NULL, '31309547', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (138, 69, NULL, '11536925', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (139, 70, NULL, '23116313', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (140, 70, NULL, '16110007', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (141, 71, NULL, '92107021', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (142, 71, NULL, '22287687', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (143, 72, NULL, '93811446', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (144, 72, NULL, '89265109', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (145, 73, NULL, '67797974', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (146, 73, NULL, '44534479', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (147, 74, NULL, '81260416', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (148, 74, NULL, '74705740', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (149, 75, NULL, '69021480', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (150, 75, NULL, '40198101', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (151, 76, NULL, '44701666', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (152, 76, NULL, '58017906', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (153, 77, NULL, '94794120', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (154, 77, NULL, '36586523', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (155, 78, NULL, '15095695', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (156, 78, NULL, '60253323', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (157, 79, NULL, '89982099', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (158, 79, NULL, '33629704', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (159, 80, NULL, '99971502', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (160, 80, NULL, '71689227', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (161, 81, NULL, '41448311', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (162, 81, NULL, '92015180', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (163, 82, NULL, '22384942', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (164, 82, NULL, '01875973', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (165, 83, NULL, '31944267', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (166, 83, NULL, '09313187', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (167, 84, NULL, '33334011', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (168, 84, NULL, '74416523', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (169, 85, NULL, '73307655', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (170, 85, NULL, '63729337', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (171, 86, NULL, '11630616', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (172, 86, NULL, '19801285', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (173, 87, NULL, '82495732', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (174, 87, NULL, '41328699', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (175, 88, NULL, '47544574', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (176, 88, NULL, '31541954', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (177, 89, NULL, '72231029', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (178, 89, NULL, '78952065', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (179, 90, NULL, '56650358', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.barcodes (id, product_id, variant_name, barcode, created_at, updated_at) VALUES (180, 90, NULL, '72668931', '2021-07-06 14:36:12', '2021-07-06 14:36:12');


--
-- Data for Name: committee_members; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.committee_members (id, name, role, active_year_id, image, description, favourite_game, favourite_sugar, quote, created_at, updated_at) VALUES (1, 'Mushi', 'ordförande', 1, NULL, 'This is the description field of the Committee_members table', 'Game', 'Sugar', NULL, '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.committee_members (id, name, role, active_year_id, image, description, favourite_game, favourite_sugar, quote, created_at, updated_at) VALUES (2, 'Hell', 'kassör', 1, NULL, 'This is the description field of the Committee_members table', 'Game', 'Sugar', 'Sug mitt FINGER!', '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.committee_members (id, name, role, active_year_id, image, description, favourite_game, favourite_sugar, quote, created_at, updated_at) VALUES (3, 'Tengil', 'prchef', 1, NULL, 'This is the description field of the Committee_members table', 'Game', 'Sugar', 'All makt åt tengil', '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.committee_members (id, name, role, active_year_id, image, description, favourite_game, favourite_sugar, quote, created_at, updated_at) VALUES (4, 'Pålen', 'inköpschef', 1, NULL, 'This is the description field of the Committee_members table', 'Game', 'Sugar', NULL, '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.committee_members (id, name, role, active_year_id, image, description, favourite_game, favourite_sugar, quote, created_at, updated_at) VALUES (5, 'Hatomik', 'spelchef', 1, NULL, 'This is the description field of the Committee_members table', 'Game', 'Sugar', NULL, '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.committee_members (id, name, role, active_year_id, image, description, favourite_game, favourite_sugar, quote, created_at, updated_at) VALUES (6, 'Penta', 'kodchef', 1, NULL, 'I made dis', 'Game', 'Sugar', NULL, '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.committee_members (id, name, role, active_year_id, image, description, favourite_game, favourite_sugar, quote, created_at, updated_at) VALUES (7, 'Mini', 'vice-sysad', 1, NULL, 'This is the description field of the Committee_members table', 'Game', 'Sugar', NULL, '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.committee_members (id, name, role, active_year_id, image, description, favourite_game, favourite_sugar, quote, created_at, updated_at) VALUES (8, 'Null', 'sysad', 1, NULL, 'This is the description field of the Committee_members table', 'Game', 'Sugar', NULL, '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.committee_members (id, name, role, active_year_id, image, description, favourite_game, favourite_sugar, quote, created_at, updated_at) VALUES (9, 'CK', 'matslav', 1, NULL, 'This is the description field of the Committee_members table', 'Game', 'Sugar', NULL, '2021-07-06 14:36:11', '2021-07-06 14:36:11');

INSERT INTO public.committee_members (id, name, role, active_year_id, image, description, favourite_game, favourite_sugar, quote, created_at, updated_at) VALUES (10, 'HåPe', 'Ordförande', 2, NULL, 'This is the description field of the Committee_members table', 'Game', 'Sugar', NULL, '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.committee_members (id, name, role, active_year_id, image, description, favourite_game, favourite_sugar, quote, created_at, updated_at) VALUES (11, 'Prty Dave', 'Kassör', 2, NULL, 'This is the description field of the Committee_members table', 'Game', 'Sugar', NULL, '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.committee_members (id, name, role, active_year_id, image, description, favourite_game, favourite_sugar, quote, created_at, updated_at) VALUES (12, 'Frugan', 'PR-Chef', 2, NULL, 'This is the description field of the Committee_members table', 'Game', 'Sugar', NULL, '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.committee_members (id, name, role, active_year_id, image, description, favourite_game, favourite_sugar, quote, created_at, updated_at) VALUES (13, 'Boel', 'Spelchef', 2, NULL, 'This is the description field of the Committee_members table', 'Game', 'Sugar', NULL, '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.committee_members (id, name, role, active_year_id, image, description, favourite_game, favourite_sugar, quote, created_at, updated_at) VALUES (14, 'Shinz', 'Kodchef', 2, NULL, 'I am the terrible person that ported the site to typescript', 'Game', 'Sugar', NULL, '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.committee_members (id, name, role, active_year_id, image, description, favourite_game, favourite_sugar, quote, created_at, updated_at) VALUES (15, 'Kong', 'Inköpschef', 2, NULL, 'This is the description field of the Committee_members table', 'Game', 'Sugar', NULL, '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.committee_members (id, name, role, active_year_id, image, description, favourite_game, favourite_sugar, quote, created_at, updated_at) VALUES (16, 'Löken', 'Vice-Sysad', 2, NULL, 'This is the description field of the Committee_members table', 'Game', 'Sugar', NULL, '2021-07-06 14:36:11', '2021-07-06 14:36:11');
INSERT INTO public.committee_members (id, name, role, active_year_id, image, description, favourite_game, favourite_sugar, quote, created_at, updated_at) VALUES (17, 'Aero', 'Sysad', 2, NULL, 'This is the description field of the Committee_members table', 'Game', 'Sugar', NULL, '2021-07-06 14:36:11', '2021-07-06 14:36:11');

--
-- Data for Name: door_statuses; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Data for Name: events; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Data for Name: game_owners; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Data for Name: game_platforms; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.game_platforms (id, name, type, bgg_type, created_at, updated_at) VALUES (1, 'Brädspel', 'boardgame', NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.game_platforms (id, name, type, bgg_type, created_at, updated_at) VALUES (2, 'Playstation X', 'videogame', NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.game_platforms (id, name, type, bgg_type, created_at, updated_at) VALUES (3, 'XBOX Q', 'videogame', NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.game_platforms (id, name, type, bgg_type, created_at, updated_at) VALUES (4, 'Nintendo Switch', 'videogame', NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.game_platforms (id, name, type, bgg_type, created_at, updated_at) VALUES (5, 'PC', 'videogame', NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.game_platforms (id, name, type, bgg_type, created_at, updated_at) VALUES (6, 'VR', 'videogame', NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');


--
-- Data for Name: games; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (1, 'voluptatum', 'Inventore qui voluptatem magnam qui voluptatem et ut. Dolorem dolorem ducimus nihil nostrum nihil. Expedita qui qui eum perspiciatis nesciunt natus corrupti.', NULL, 1, 5, 5, '1988', 49, 245, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (2, 'voluptatem', 'Voluptatem cumque doloribus laudantium quisquam harum est voluptatem. Et qui ipsa numquam aut. Quae et et tempora nulla est. Libero enim mollitia sint quaerat exercitationem unde modi delectus.', NULL, 1, 4, 8, '2007', 133, 239, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (3, 'ipsum', 'In nisi minima quis nulla. Non consequuntur sapiente tenetur saepe voluptatem nostrum. Possimus cum blanditiis perspiciatis similique ipsa sit. Aut suscipit delectus itaque optio quos quaerat illo. Neque et vel saepe officia ipsum.', NULL, 1, 1, 8, '1972', 143, 354, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (4, 'et', 'Earum commodi accusantium in provident unde in. Nemo fugit eaque recusandae id et. Accusamus veniam maxime vitae doloribus vel aut a.', NULL, 1, 2, 5, '1981', 117, 332, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (5, 'sint', 'Nulla voluptatum fuga praesentium repudiandae quibusdam. Deleniti praesentium id molestiae facere. Dolor nulla enim quis fugiat aperiam consequuntur.', NULL, 1, 4, 10, '1992', 34, 260, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (6, 'vero', 'Nesciunt quam architecto voluptatem similique repellat. Quibusdam totam sit ipsum. Fuga odio rerum dignissimos voluptatem. Excepturi incidunt amet et repellat esse quam eos exercitationem.', NULL, 1, 1, 6, '1992', 74, 359, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (7, 'assumenda', 'Eius culpa ullam vel. Sint delectus tempore porro sint sit. Reiciendis consequatur voluptatem dolores sunt et. Nihil eligendi sapiente qui porro velit repudiandae.', NULL, 1, 4, 7, '2006', 72, 323, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (8, 'et', 'Soluta qui est laboriosam harum aut est. Nostrum at voluptas doloremque quo. Dolores voluptates quaerat architecto dicta ea quam unde.', NULL, 1, 4, 5, '1983', 85, 285, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (9, 'et', 'Soluta beatae autem ut illo odio nulla optio. Sed quisquam dolorem distinctio consequatur saepe voluptas.', NULL, 1, 5, 8, '1974', 81, 341, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (10, 'dolorem', 'At temporibus voluptas libero et. Recusandae dolor sequi beatae. Est nesciunt dolor sunt voluptatibus. Quas reprehenderit et dolor tenetur modi quae aspernatur accusantium.', NULL, 1, 3, 7, '1972', 81, 236, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (11, 'sunt', 'Et eveniet voluptas eos minus velit quo aperiam. Nam vel sed est nesciunt fugiat rerum. Facere sint eos et excepturi. Inventore aliquid maxime cupiditate. Tenetur rerum et dolores deleniti nemo perferendis.', NULL, 2, 5, 8, '1987', 110, 265, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (12, 'voluptatem', 'Rerum illo minima modi adipisci perspiciatis nulla. Architecto maiores quod quam quibusdam quia. Ad nostrum alias id distinctio omnis repudiandae ea sapiente. Dolore laudantium vel delectus mollitia accusamus eos.', NULL, 2, 3, 7, '1970', 109, 227, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (13, 'est', 'Dolores quos quod est facilis asperiores harum. Ea vel et nostrum autem ut hic nisi. Quibusdam ab sequi quo id consequuntur modi repudiandae fuga. Non dignissimos maiores consequatur iure ducimus atque amet.', NULL, 2, 4, 6, '1985', 39, 205, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (14, 'temporibus', 'Odit eaque animi et aut et harum. Id repellendus autem vitae aut voluptates voluptatibus eum. Mollitia omnis est qui placeat unde qui ea. Architecto autem facilis distinctio magni voluptates omnis culpa. Distinctio vitae minima quo esse.', NULL, 2, 5, 8, '1983', 78, 281, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (15, 'natus', 'Occaecati occaecati hic minus aliquam quibusdam accusamus. Natus atque ipsum fugit reiciendis nisi pariatur est. Molestiae tenetur cum occaecati totam autem nihil dolor natus. Dolorum rerum quae eos minus ullam iusto accusantium.', NULL, 2, 2, 10, '1988', 74, 193, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (16, 'dolores', 'Error non velit autem sint quisquam neque voluptatum. Modi ipsam sunt iusto. Optio quidem velit eligendi a itaque. Recusandae animi iste quas rem omnis.', NULL, 2, 2, 10, '1984', 163, 245, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (17, 'eius', 'Soluta quos quos ipsa adipisci. Quis ullam aliquam aliquam quia. Est molestiae consequuntur nihil eaque. Asperiores ipsum ut aut cumque.', NULL, 2, 4, 10, '2007', 69, 294, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (18, 'esse', 'Sit at dolores est dignissimos qui praesentium illo. Aut ipsam dolore ullam omnis odit repellat et. Consectetur unde itaque facilis aut repudiandae sequi ut. Reprehenderit excepturi nihil aliquam est.', NULL, 2, 1, 8, '1977', 80, 200, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (19, 'commodi', 'Commodi amet veritatis vel ut et. Nihil vitae cumque quis delectus cupiditate animi et. Id voluptatem iste impedit ratione. Sed corporis vel alias officiis impedit.', NULL, 2, 3, 8, '1987', 180, 276, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (20, 'corporis', 'Ex occaecati quidem voluptatem veniam. Dolor et et numquam quasi. Voluptates quis veniam et. Omnis debitis modi consectetur architecto.', NULL, 2, 3, 6, '1986', 62, 330, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (21, 'voluptatem', 'Dolor eos molestiae voluptatem vel ipsam veritatis. Veritatis quae consequatur necessitatibus. Fugiat aut iure ut.', NULL, 3, 3, 5, '1999', 119, 268, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (22, 'modi', 'Non ad libero delectus quas et exercitationem repudiandae quo. Qui ut esse iure repellat accusamus aliquid. Possimus facilis sit voluptatem nisi nulla earum. Itaque cupiditate aut voluptas necessitatibus.', NULL, 3, 3, 6, '2017', 139, 223, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (23, 'incidunt', 'Tenetur et aut ut quos. Et quia officia quis quam accusantium et. Aperiam eligendi vitae aut tenetur molestiae voluptas et. Eos totam architecto ut sit. Voluptas id ut ut ut voluptas dolorum.', NULL, 3, 4, 10, '1989', 137, 243, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (24, 'ut', 'Quo praesentium culpa nihil ipsum animi laudantium dignissimos. Vitae cumque dolorem facilis porro sit omnis. Neque sequi libero in vitae cupiditate non et. Iure unde et quaerat in aut qui deleniti.', NULL, 3, 4, 10, '2018', 166, 181, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (25, 'consequatur', 'Cupiditate deserunt temporibus ad. Quo in magnam voluptas commodi itaque et voluptas. Quod voluptas est omnis.', NULL, 3, 3, 9, '1984', 133, 322, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (26, 'est', 'Aliquid velit ducimus laborum velit consequuntur possimus. Reiciendis porro et ut fugit alias omnis. Delectus ab ab eligendi. Tempore fuga minus qui rerum.', NULL, 3, 1, 9, '1996', 60, 204, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (27, 'harum', 'Et recusandae voluptatem dicta fuga. Sit labore dolorem assumenda temporibus a occaecati quis. Velit unde sit quia est consequatur. Maiores pariatur fugiat officia quisquam tenetur assumenda reiciendis.', NULL, 3, 1, 5, '2005', 93, 328, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (28, 'doloribus', 'Rerum quia incidunt enim commodi. Necessitatibus qui molestiae quis. Delectus voluptate velit repellendus beatae molestiae eveniet. Fugiat sunt omnis rerum laudantium ducimus qui voluptatem.', NULL, 3, 3, 6, '1994', 105, 269, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (29, 'repellat', 'Aut cum culpa quasi dolorem qui ratione sunt corporis. Adipisci sed est et aperiam commodi ex maxime. Dolorem facere quod ut odit fugit consequatur animi.', NULL, 3, 3, 8, '1998', 161, 299, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (30, 'rerum', 'Voluptatum vitae omnis qui autem. Autem et placeat et dolores. Odio eum quis autem mollitia qui rem minus.', NULL, 3, 2, 7, '2006', 66, 220, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (31, 'magnam', 'Quibusdam dolorem voluptatibus distinctio incidunt et facilis quia. Qui sed assumenda provident quis sequi ut.', NULL, 4, 1, 7, '1993', 52, 322, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (32, 'alias', 'Inventore qui quidem amet mollitia nihil. Et consequatur accusantium harum veniam necessitatibus. Id aut aperiam magni aliquid et. Labore est deleniti quis ducimus cumque sunt saepe. Ab alias aut facilis itaque atque.', NULL, 4, 1, 5, '2003', 162, 240, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (33, 'in', 'Eos commodi est ducimus et sit. Accusamus eveniet sunt eos sapiente qui commodi enim esse. Molestiae molestiae sed eum at. Quia ipsam quia cumque aperiam sint.', NULL, 4, 3, 5, '1989', 104, 334, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (34, 'sed', 'Nesciunt fugiat quod quos ut vel. Labore quisquam qui minima et nobis omnis a. Voluptatem accusamus vel et minima.', NULL, 4, 3, 8, '1979', 36, 256, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (35, 'labore', 'Est labore aliquid accusantium voluptatem deserunt velit. Magnam veniam pariatur adipisci aliquid. Accusantium aut et ea nulla. Est officiis quia quis impedit ea dolorem tempora.', NULL, 4, 3, 6, '2015', 96, 199, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (36, 'voluptas', 'Sit delectus rem nihil amet odit. Rerum ut corrupti ut recusandae quos sit dicta.', NULL, 4, 4, 10, '1999', 174, 216, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (37, 'quidem', 'Est non aut autem ullam non ut. Delectus ut consequatur nobis eum voluptas sed neque.', NULL, 4, 4, 8, '2000', 94, 263, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (38, 'quam', 'Aut quaerat eius nostrum. Nam maxime repudiandae dolore qui voluptas. Velit corporis iste repellendus et sed nulla. Est aut deserunt error ratione dolore voluptatem.', NULL, 4, 1, 7, '2021', 157, 218, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (39, 'quasi', 'Tempora facilis quis repudiandae aperiam incidunt at nisi. Possimus atque minima minus enim sapiente magni velit veritatis. Dolores voluptate rem et dolore est. Sunt maiores voluptatem alias iure enim repellendus voluptates. Quia ullam ut aut rem.', NULL, 4, 5, 7, '2004', 38, 184, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (40, 'quod', 'Et sunt occaecati et quia possimus et molestiae. Exercitationem numquam voluptatibus similique eum sapiente tenetur. Fugiat et voluptatem est. Optio deserunt quia doloribus.', NULL, 4, 1, 8, '2012', 41, 262, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (41, 'incidunt', 'Omnis quis omnis et maiores. Dolor eos et placeat. Non laboriosam et ipsum ad est eos rem. Saepe beatae qui esse quia.', NULL, 5, 3, 7, '1971', 175, 250, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (42, 'sit', 'Ut sed mollitia earum sit. Maiores ipsa error rem quibusdam accusamus aliquam beatae.', NULL, 5, 4, 10, '1994', 144, 199, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (43, 'deserunt', 'Pariatur velit sequi sit. Officia labore molestiae corrupti amet. Sapiente voluptas magni consequatur porro. Quos repellendus laboriosam ea quibusdam.', NULL, 5, 4, 5, '1979', 178, 228, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (44, 'ut', 'Sed maiores reprehenderit sed. Quo facere amet numquam voluptas. Molestiae veniam sit ut.', NULL, 5, 2, 6, '2006', 75, 271, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (45, 'vel', 'Voluptas sit molestiae et debitis officia adipisci. Quas ex sit quo numquam cum pariatur sint. Ut id cum aut molestiae explicabo consequuntur officiis. Quas officiis consequatur dolore consequatur libero.', NULL, 5, 2, 8, '1981', 111, 188, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (46, 'natus', 'Cumque et quia qui aut debitis. Ipsum in esse est voluptas officiis. Ratione est ullam vero.', NULL, 5, 2, 7, '1992', 135, 230, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (47, 'aliquid', 'Veniam eos consequatur in minima necessitatibus. Consequuntur nihil atque modi aut quia repellat ea. Soluta voluptatem fuga ut illo consequatur magni accusantium nesciunt.', NULL, 5, 3, 7, '1973', 180, 317, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (48, 'quos', 'Dolor unde est eos et esse possimus quaerat. Nemo odio voluptas consequuntur et et. Reiciendis quasi recusandae aut hic pariatur voluptatem.', NULL, 5, 3, 8, '1980', 145, 231, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (49, 'ab', 'Repellat ullam nihil ullam rerum consequatur libero. Ut quibusdam deserunt minima vel modi recusandae. Possimus exercitationem dolores iusto voluptatem eius et exercitationem. Omnis et vitae et quis ut qui.', NULL, 5, 5, 10, '2019', 31, 246, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (50, 'ab', 'Delectus officiis commodi deserunt culpa omnis optio. Ut voluptatem quia eligendi maiores. Esse soluta quas doloribus voluptates ipsa. Ullam aut temporibus porro ullam nulla omnis aspernatur fugiat.', NULL, 5, 4, 5, '1974', 122, 253, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (51, 'sed', 'Explicabo inventore aut et nihil deleniti illo qui. Nihil dolorum esse sapiente ex. Eum mollitia temporibus sed perspiciatis. Placeat laudantium corporis ad facilis officiis.', NULL, 6, 4, 10, '1990', 99, 261, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (52, 'qui', 'Quis modi voluptatem quam blanditiis voluptas ipsa aut. Vel tempora eum pariatur. Aspernatur perferendis nihil nihil ipsa quaerat fugit minus. Molestias consequatur sequi porro cumque debitis.', NULL, 6, 3, 6, '2000', 118, 253, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (53, 'maxime', 'Ea voluptatem dignissimos asperiores consequatur excepturi quae nobis. Voluptatem aliquam vel a labore fugit laudantium adipisci earum. Sint possimus officiis inventore voluptatem sint officia iusto. Blanditiis minima aut ea.', NULL, 6, 5, 6, '1978', 111, 183, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (54, 'quibusdam', 'Explicabo corporis rem et est dolor hic ducimus. Laborum et dolorum earum autem aliquid. Velit rerum et quia adipisci modi rerum.', NULL, 6, 3, 6, '1970', 71, 186, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (55, 'dolor', 'Optio aspernatur et quidem at ut debitis ut laboriosam. Eligendi alias velit dignissimos odit natus ipsam. Animi quia consequuntur commodi ipsum odio consequatur et. Velit sunt accusantium et excepturi recusandae alias doloremque.', NULL, 6, 3, 8, '2006', 129, 308, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (56, 'qui', 'Nesciunt eos sed ipsam id. Ipsam fugit et soluta corporis. Quis aut esse dolorum mollitia. Rerum mollitia labore quidem quisquam.', NULL, 6, 5, 6, '2017', 71, 217, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (57, 'vitae', 'Mollitia similique fuga eveniet facere illum occaecati. Minus tempore et repudiandae alias. Iusto et voluptatum deleniti quos aut omnis aut. Perferendis vero sed et recusandae accusamus omnis at.', NULL, 6, 5, 10, '1992', 165, 345, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (58, 'recusandae', 'Quia voluptas et nam. A impedit voluptate ad tenetur recusandae. Architecto et non consectetur eum quis. Tenetur officiis dolores distinctio voluptas voluptatem rem.', NULL, 6, 2, 5, '2012', 126, 231, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (59, 'et', 'Qui consequatur in sint facere sunt qui deleniti. Pariatur natus fugiat voluptas. Et velit libero voluptates veritatis. Commodi aut aut est veniam tempore quasi.', NULL, 6, 4, 6, '1988', 177, 222, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.games (id, name, description, bgg_id, game_platform_id, min_players, max_players, published_year, min_playtime, max_playtime, expansion_to, game_owner_id, created_at, updated_at) VALUES (60, 'voluptatibus', 'Voluptatem blanditiis animi impedit sit. Quibusdam rerum temporibus dolor quis beatae mollitia et in. Itaque placeat soluta et eveniet.', NULL, 6, 2, 9, '2003', 114, 317, NULL, NULL, '2021-07-06 14:36:13', '2021-07-06 14:36:13');


--
-- Data for Name: jobs; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Data for Name: password_resets; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- Data for Name: purchase_histories; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.purchase_histories (id, account_id, sum, created_at, updated_at) VALUES (1, 1, 98, '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_histories (id, account_id, sum, created_at, updated_at) VALUES (2, 1, 112, '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_histories (id, account_id, sum, created_at, updated_at) VALUES (3, 1, 54, '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_histories (id, account_id, sum, created_at, updated_at) VALUES (4, 1, 121, '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_histories (id, account_id, sum, created_at, updated_at) VALUES (5, 1, 107, '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_histories (id, account_id, sum, created_at, updated_at) VALUES (6, 2, 137, '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_histories (id, account_id, sum, created_at, updated_at) VALUES (7, 2, 111, '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_histories (id, account_id, sum, created_at, updated_at) VALUES (8, 2, 85, '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_histories (id, account_id, sum, created_at, updated_at) VALUES (9, 2, 140, '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_histories (id, account_id, sum, created_at, updated_at) VALUES (10, 2, 107, '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_histories (id, account_id, sum, created_at, updated_at) VALUES (11, 3, 162, '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_histories (id, account_id, sum, created_at, updated_at) VALUES (12, 3, 75, '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_histories (id, account_id, sum, created_at, updated_at) VALUES (13, 3, 162, '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_histories (id, account_id, sum, created_at, updated_at) VALUES (14, 3, 70, '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_histories (id, account_id, sum, created_at, updated_at) VALUES (15, 3, 22, '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_histories (id, account_id, sum, created_at, updated_at) VALUES (16, 4, 159, '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_histories (id, account_id, sum, created_at, updated_at) VALUES (17, 4, 82, '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_histories (id, account_id, sum, created_at, updated_at) VALUES (18, 4, 138, '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_histories (id, account_id, sum, created_at, updated_at) VALUES (19, 4, 171, '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_histories (id, account_id, sum, created_at, updated_at) VALUES (20, 4, 118, '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_histories (id, account_id, sum, created_at, updated_at) VALUES (21, 5, 86, '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_histories (id, account_id, sum, created_at, updated_at) VALUES (22, 5, 115, '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_histories (id, account_id, sum, created_at, updated_at) VALUES (23, 5, 103, '2021-07-06 14:36:12', '2021-07-06 14:36:13');
INSERT INTO public.purchase_histories (id, account_id, sum, created_at, updated_at) VALUES (24, 5, 66, '2021-07-06 14:36:12', '2021-07-06 14:36:13');
INSERT INTO public.purchase_histories (id, account_id, sum, created_at, updated_at) VALUES (25, 5, 16, '2021-07-06 14:36:12', '2021-07-06 14:36:13');


--
-- Data for Name: purchase_history_products; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (1, 1, 97, 'jrowe', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (2, 1, 1, 'emory.morar', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (3, 2, 59, 'mparker', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (4, 2, 53, 'borer.brenden', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (5, 3, 4, 'aniyah97', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (6, 3, 50, 'sprohaska', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (7, 4, 33, 'senger.kaleigh', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (8, 4, 88, 'xdeckow', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (9, 5, 31, 'egoyette', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (10, 5, 76, 'devonte55', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (11, 6, 76, 'oral.purdy', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (12, 6, 61, 'joe07', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (13, 7, 23, 'carol.bayer', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (14, 7, 88, 'madison50', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (15, 8, 27, 'zoila.rohan', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (16, 8, 58, 'tatum00', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (17, 9, 66, 'tboyle', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (18, 9, 74, 'drice', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (19, 10, 25, 'dee74', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (20, 10, 82, 'syble.littel', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (21, 11, 72, 'dario.schiller', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (22, 11, 90, 'arlo87', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (23, 12, 27, 'boyer.imogene', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (24, 12, 48, 'swintheiser', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (25, 13, 69, 'gwendolyn55', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (26, 13, 93, 'emanuel65', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (27, 14, 42, 'rowe.darian', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (28, 14, 28, 'lucie65', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (29, 15, 0, 'durgan.shawn', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (30, 15, 22, 'yosinski', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (31, 16, 73, 'veum.isaias', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (32, 16, 86, 'waters.edwin', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (33, 17, 72, 'naomi18', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (34, 17, 10, 'gankunding', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (35, 18, 81, 'nova01', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (36, 18, 57, 'felix.halvorson', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (37, 19, 87, 'ystanton', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (38, 19, 84, 'noemy.mccullough', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (39, 20, 45, 'louisa26', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (40, 20, 73, 'stanton.tracey', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (41, 21, 49, 'creola71', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (42, 21, 37, 'greenholt.kirk', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (43, 22, 73, 'thowe', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (44, 22, 42, 'stamm.breanne', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (45, 23, 64, 'janie.spinka', '2021-07-06 14:36:12', '2021-07-06 14:36:12');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (46, 23, 39, 'fpouros', '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (47, 24, 50, 'junior.hessel', '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (48, 24, 16, 'raegan.prosacco', '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (49, 25, 8, 'vern.sauer', '2021-07-06 14:36:13', '2021-07-06 14:36:13');
INSERT INTO public.purchase_history_products (id, purchase_history_id, price, name, created_at, updated_at) VALUES (50, 25, 8, 'xschumm', '2021-07-06 14:36:13', '2021-07-06 14:36:13');


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.users (id, name, email, email_verified_at, password, remember_token, created_at, updated_at, api_token) VALUES (1, 'test', 'test@example.com', NULL, '$2y$10$cp.6IEF/bScB2qjeejJ5f..BZfICWF61CkdorKYwI.bFPL1x7Zw7u', '', '2021-07-06 14:36:11', '2021-07-06 14:36:11', 'R85bASuMKAtAzfuKfaFzfwMRunj9fOMTL61LjxqyPxCJ9vVHLZ7C3XCXD6cp');


--
-- Name: accounts_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.accounts_id_seq', 5, true);


--
-- Name: active_years_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.active_years_id_seq', 1, true);


--
-- Name: barcodes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.barcodes_id_seq', 180, true);


--
-- Name: categories_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.categories_id_seq', 3, true);


--
-- Name: committee_members_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.committee_members_id_seq', 9, true);


--
-- Name: door_statuses_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.door_statuses_id_seq', 1, true);


--
-- Name: events_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.events_id_seq', 1, false);


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- Name: game_owners_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.game_owners_id_seq', 1, false);


--
-- Name: game_platforms_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.game_platforms_id_seq', 6, true);


--
-- Name: games_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.games_id_seq', 60, true);


--
-- Name: jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.jobs_id_seq', 1, false);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.migrations_id_seq', 22, true);


--
-- Name: products_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.products_id_seq', 90, true);


--
-- Name: purchase_histories_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.purchase_histories_id_seq', 25, true);


--
-- Name: purchase_history_products_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.purchase_history_products_id_seq', 50, true);


--
-- Name: telescope_entries_sequence_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.telescope_entries_sequence_seq', 987, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.users_id_seq', 1, true);


--
-- PostgreSQL database dump complete
--

