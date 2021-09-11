@echo off 
cmd.exe /E:ON /K C:\Ruby22-x64\bin\sass --compass --watch --sourcemap _bootstrap.scss:../css/bootstrap.css
PAUSE