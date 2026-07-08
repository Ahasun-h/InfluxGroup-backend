-- Troubleshooting SQL for Career Opportunities Update Issue

-- 1. Check if the table exists and show its structure
SHOW TABLES LIKE 'career_opportunities';

-- 2. Describe the table structure
DESCRIBE career_opportunities;

-- 3. Check if there are any records in the table
SELECT * FROM career_opportunities;

-- 4. Check the most recent records
SELECT * FROM career_opportunities ORDER BY created_at DESC LIMIT 5;

-- 5. Check if there are any deleted records (soft deletes)
SELECT * FROM career_opportunities WHERE deleted_at IS NOT NULL;

-- 6. Check for any specific job by ID (replace 1 with actual ID)
SELECT * FROM career_opportunities WHERE id = 1;

-- 7. Verify the data types match expectations
SELECT
    id,
    title,
    is_active,
    type,
    order,
    created_at,
    updated_at,
    deleted_at
FROM career_opportunities;