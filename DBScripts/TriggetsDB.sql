-- Логирование смены электронного адреса (email) на уровне БД
CREATE OR REPLACE FUNCTION log_user_email_change()
RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO user_changes_logs(user_id, field_name, old_value, new_value, changed_at, changed_by)
	VALUES (
		NEW.user_id, 
		'email',
		CONCAT('Пользователь ', NEW.login, ' изменил email с ', OLD.email, ' на ', NEW.email, ' в ', TO_CHAR(CURRENT_TIMESTAMP, 'DD-MM-YYYY HH24:MI:SS')),
		NEW.display_name, 
		CURRENT_TIMESTAMP, 
		NEW.user_id
	);
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Триггер для отслеживания изменений поля email
CREATE TRIGGER email_update_trigger
AFTER UPDATE OF email ON users
FOR EACH ROW
EXECUTE FUNCTION log_user_email_change();


-- Логирование изменения роли пользователя
CREATE OR REPLACE FUNCTION log_user_role_change()
RETURNS TRIGGER AS $$
DECLARE
    old_role_name VARCHAR;
    new_role_name VARCHAR;
BEGIN
    SELECT role_name INTO old_role_name FROM roles WHERE role_id = OLD.role_id;
    SELECT role_name INTO new_role_name FROM roles WHERE role_id = NEW.role_id;
    
    INSERT INTO user_changes_logs(user_id, field_name, old_value, new_value, changed_at, changed_by)
    VALUES (
        NEW.user_id, 
        'role_name', 
        CONCAT('У пользователя ', NEW.login, ' была изменена роль с ', old_role_name, ' на ', new_role_name, ' в ', TO_CHAR(CURRENT_TIMESTAMP, 'DD-MM-YYYY HH24:MI:SS')),
        new_role_name, 
        CURRENT_TIMESTAMP, 
        NEW.user_id
    );
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Триггер для отслеживания изменений поля role_id (ссылается на таблицу roles)
CREATE TRIGGER role_update_trigger
AFTER UPDATE OF role_id ON users
FOR EACH ROW
EXECUTE FUNCTION log_user_role_change();


-- Логирование изменений отображаемого имени display_name в таблице user_details
CREATE OR REPLACE FUNCTION log_display_name_change()
RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO user_changes_logs(user_id, field_name, old_value, new_value, changed_at, changed_by)
    VALUES (
        NEW.user_id, 
        'display_name', 
        CONCAT('Пользователь ', NEW.login, ' изменил отображаемое имя с ', OLD.display_name, ' на ', NEW.display_name, ' в ', TO_CHAR(CURRENT_TIMESTAMP, 'DD-MM-YYYY HH24:MI:SS')),
        NEW.display_name, 
        CURRENT_TIMESTAMP, 
        NEW.user_id
    );
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Триггер для отслеживания изменений поля display_name в таблице user_details
CREATE TRIGGER display_name_update_trigger
AFTER UPDATE OF display_name ON user_details
FOR EACH ROW
EXECUTE FUNCTION log_display_name_change();


-- Логирование изменений аватарки в таблице user_details
CREATE OR REPLACE FUNCTION log_avatar_change()
RETURNS TRIGGER AS $$
DECLARE 
    user_login VARCHAR;
BEGIN
    SELECT login INTO user_login 
    FROM users 
    WHERE user_id = NEW.user_id;

    INSERT INTO user_changes_logs(user_id, field_name, old_value, new_value, changed_at, changed_by)
    VALUES (
        NEW.user_id, 
        'avatar_url', 
        CONCAT('Пользователь ', user_login, ' изменил аватарку с ', OLD.avatar_url, ' на ', NEW.avatar_url, ' в ', TO_CHAR(CURRENT_TIMESTAMP, 'DD-MM-YYYY HH24:MI:SS')),
        NEW.avatar_url, 
        CURRENT_TIMESTAMP, 
        NEW.user_id
    );
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Триггер для отслеживания изменений аватарки
CREATE TRIGGER avatar_update_trigger
AFTER UPDATE OF avatar_url ON user_details
FOR EACH ROW
EXECUTE FUNCTION log_avatar_change();