@echo off
echo Creating desktop shortcuts for Transcript Management...

set DESKTOP=%USERPROFILE%\Desktop
set PROJECT_DIR=%~dp0
set PROJECT_NAME=Transcript Management

echo Set oWS = WScript.CreateObject("WScript.Shell") > CreateShortcut.vbs
echo sLinkFile = "%DESKTOP%\%PROJECT_NAME%.lnk" >> CreateShortcut.vbs
echo Set oLink = oWS.CreateShortcut(sLinkFile) >> CreateShortcut.vbs
echo oLink.TargetPath = "%PROJECT_DIR%public\quick-access.html" >> CreateShortcut.vbs
echo oLink.IconLocation = "%SystemRoot%\System32\SHELL32.dll,4" >> CreateShortcut.vbs
echo oLink.Save >> CreateShortcut.vbs

cscript //nologo CreateShortcut.vbs
del CreateShortcut.vbs

echo Desktop shortcut created successfully!
echo.
echo You can now access your project quickly from the desktop.
pause
