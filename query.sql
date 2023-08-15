create extension postgis;

SELECT * from hanoi4

SELECT * from hanoi6

SELECT * from hanoi8

SELECT * from daihoc

SELECT gid_1, name_1, type_1, name_0, area , ST_AsGeoJson(geom) as geo from hanoi4

SELECT gid_2, name_2, type_2, name_1, name_0, area , ST_AsGeoJson(geom) as geo from hanoi6  where ST_Within('SRID=4326;POINT(105.72583006974311 21.168532879331295)'::geometry,geom);

SELECT gid_3, name_3, type_3, name_2, name_1, name_0, area , ST_AsGeoJson(geom) as geo from hanoi8  where ST_Within('SRID=4326;POINT(105.72583006974311 21.168532879331295)'::geometry,geom);


SELECT gid_1, name_1, type_1, name_0, area , ST_AsGeoJson(geom) as geo from "hanoi4"

SELECT full_id, name, phone, website, email, url_img, addr_stree, ST_AsGeoJson(geom) as geo from daihoc where ST_Distance('POINT(105.61411285295614 20.9729327598897)',ST_AsText(geom)) = (SELECT min(ST_Distance('POINT(105.61411285295614 20.9729327598897)',ST_AsText(geom))) from daihoc) and ST_Distance('POINT(105.61411285295614 20.9729327598897)',ST_AsText(geom)) < 0.05;


SELECT ST_AsGeoJson(geom) as geo from daihoc
WHERE ST_Distance('POINT(105.82563420000001 21.0070969)',ST_AsText(geom)) < 0.05
ORDER BY ST_Distance('POINT(105.82563420000001 21.0070969)',ST_AsText(geom)) ASC limit 5

SELECT ST_AsGeoJson(geom) as geo from daihoc where ST_Distance('POINT(105.8256593 21.0071144)',ST_AsText(geom)) < 0.05 ORDER BY ST_Distance('POINT(105.8256593 21.0071144)',ST_AsText(geom)) ASC limit 5