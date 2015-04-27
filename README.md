yii2-advanced-template
======================

Start template, based on yii2-advanced-template

 
Features
-------------------

- added rest api app
- added to backend Admin LTE theme

Installation
-------------------

1. Create database

2. ``` cd /var/www/ ```

3. ``` git clone https://github.com/mikolazp/yii2-advanced-template.git ./yii2-advanced-template.dev ```

4. ``` cd yii2-advanced-template.dev/ ```

5. ``` composer create-project ```

6. ``` cd _protected/ ```

7. ``` ./init ```

8. Change the parameters to be correct for your database in file: <br/>
 ``` _protected/common/config/main-local.php ``` 

9. ``` ./yii migrate ``` 

10. ``` ./yii rbac/init ```