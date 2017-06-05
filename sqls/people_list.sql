SELECT
	pt.*,
    e.event_id as event_event_id,


    e.title as event_title,
    e.course_cat_id  as event_course_cat_id,
    e.course_subcat_id  as event_course_subcat_id,
    e.coverage_level  as event_coverage_level,
    e.coverage_location  as event_coverage_location,
    e.year  as event_year,
    e.start_date  as event_start_date,
    e.end_date  as event_end_date,
    e.venue  as event_venue,
    e.address  as event_address,
    e.country  as event_country,
    e.created_by  as event_created_by,
    e.created_date  as event_created_date,
    e.deleted_by  as event_deleted_by,
    e.deleted_date  as event_deleted_date,
    e.deleted  as event_deleted,
    e.longitude  as event_longitude,
    e.latitude  as event_latitude,
    e.Budget_unit  as event_Budget_unit,
    e.event_code  as event_event_code,
    e.district  as event_district,
    e.vdc  as event_vdc,
    e.ward_no  as event_ward_no,
    e.tole  as event_tole,

    count(pt.event_id) as event_count
FROM
    (

        SELECT
            p.person_id as person_id,
            p.title as person_title,
            p.fullname as person_fullname,
            p.dob_np as person_dob_np,
            p.dob_en as person_dob_en,
            p.gender as person_gender,
            p.p_address as person_p_address,
            p.c_address as person_c_address,
            p.photo   as person_photo ,
            p.country  as person_country,
            p.phone  as person_phone,
            p.mobile  as person_mobile,
            p.email  as person_email,
            p.org_name  as person_org_name,
            p.org_address   as person_org_address,
            p.org_phone   as person_org_phone,
            p.org_fax   as person_org_fax,
            p.position  as person_position,
            p.current_status  as person_current_status,
            p.created_by  as person_created_by,
            p.created_date  as person_created_date,
            p.deleted_by  as person_deleted_by,
            p.deleted_date  as person_deleted_date,
            p.deleted  as person_deleted,
            p.caste_ethnicity  as person_caste_ethnicity,

	        t.participated_in_id,
        	t.person_age,
        	t.event_id ,
        	t.is_instructor,
        	t.deleted as participated_in_deleted,
        	t.certification_code ,
        	t.certification_status,
        	t.certification_date ,
        	t.beneficiary_type ,
        	t.participation_role,
        	t.experience_years

        FROM
            person p
        LEFT JOIN
            participated_in t ON p.person_id = t.person_id
    ) as pt
LEFT JOIN
	events e ON pt.event_id = e.event_id
GROUP BY person_id