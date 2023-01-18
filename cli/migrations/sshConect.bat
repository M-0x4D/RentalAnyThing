ECHO OFF
CLS
:MENU
ECHO.
ECHO ........................
ECHO SSH servers
ECHO ........................
ECHO.
ECHO 1 - Web Server 1
ECHO 2 - Web Server 2
ECHO E - EXIT
ECHO.

SET /P M=Type 1 - 2 then press ENTER:
IF %M%==1 GOTO WEB1
IF %M%==2 GOTO WEB2
IF %M%==E GOTO EOF

REM ------------------------------
REM SSH Server details
REM ------------------------------

:WEB1
CLS
call ssh ssh-w01d5aea@v1158262.kasserver.com
cmd /k

:WEB2
CLS
call ssh user@xxx.xxx.xxx.xxx
cmd /k