# CHANGELOG
Current and upcoming changes to the *KissHMVC* framework.

## NOTES
This isn't a strict changelog. Sometimes, if not many, if i say a bug is fixed it just means it's working for the most part or is a temporary fix. I try to document any changes I make to code. But i do forget sometimes, as well as updating this file.
## IDEAS
- 

## [UNRELEASED]
- 
- 

## == 1.0.0 - 2019-02-01 - Bug Fix ==
- Rewrote code from an older project I started in 2018.

## == 1.1.0 - 2019/10/21 - Present - Bug Fix ==
- Rewrote code yet again. The framework now has a Singleton that works as a super object, just like CodeIgniter. And also, now the frawemork has no trouble displaying views when uploaded to server.
- Fixed clashes between between Default MVC and Modules. The problem was that that things were loading twice because the system was unable to distinguish between default models, views, and controllers and module views, controllers, and models.
- Add better logic and functionality to the URL helpers.
- Worked a bit on error handling and commented files.
- Added ability to load database as a library.
- Got Session library working for the most part; Flashdata works now but still fine-tuning things.
- Methods with an underscore are now private with the bit of code added; still need to get this working for core files as well for security.
