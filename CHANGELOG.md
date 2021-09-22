# Changelog

## [2.4] - 2021-09-22
### Changed
- Updaste trademark
- Set Dark Mode on initial load if set in OS
- Shrink spacing between options

## [2.3] - 2021-09-19
### Changed
- Set version query on CSS files to force refresh
- Improved footer appearance

## [2.2] - 2021-09-18
### Changed
- Changed Dark Mode button text to black for readability
- New Dark Mode header (Thanks Rath!)
- Added -- as a continue marker
- Made it so parsed posts are independently scrollable
- Added /c as a generic manual break
- Shrunk the height of the header

### Fixed
- Changed parsing activation from onkeyup to oninput to fix edge case errors

## [2.1] - 2020-10-26
### Changed
- Remove continue marker at start of manual continues
- Code formatting
- Added additional code comments

### Fixed
- Alignment issue in Chromium-based Browsers
- Bug in manual continues

## [2.0] - 2020-10-02
### Changed
- Rewrote entire application in Javascript
  - Program parses as you type with no need to submit the form
  - Program parses faster
- Dark Mode Added
- Changed method of manual break from continuation character to chat command

### Fixed
- Using hyphens in your text while using hyphen as your continuation character will no longer break your posts

## [1.4] - 2019-03-21
### Changed
- Remove the need to have the initial /e for emote posting
- Guild Name and add main RP character of author
- Cleanup PHP
- Add numbers to output blocks

### Fixed
- Don't print output if buffer is empty
- Don't print final box if empty
- Resolve "Offset not contained in string warnings" for empty final string

## [1.3] - 2019-02-01
### Changed
- Added Eighth Note Continue Character
- Convert string functions to multibyte variants

### Fixed
- HTML Formating
- Resolve "Offset not contained in string warnings"

## [1.2] - 2019-01-07
### Changed
- Layout and style of page

### Fixed
- Resolve bug where double white spaces can occur when using a manual continue
- Resolve edge case bug where manual continue markers in final post are not used

## [1.1] - 2019-01-05
### Added
- Allow the ability to manually set continue markers in chat buffer

### Changed
- Layout and style of page

## 1.0 - 2018-12-26
- Initial release

[2.4]: https://github.com/NihlusDuskstalker/gw2chatbufferbuddy/compare/v2.3...v2.4
[2.3]: https://github.com/NihlusDuskstalker/gw2chatbufferbuddy/compare/v2.2...v2.3
[2.2]: https://github.com/NihlusDuskstalker/gw2chatbufferbuddy/compare/v2.1...v2.2
[2.1]: https://github.com/NihlusDuskstalker/gw2chatbufferbuddy/compare/v2.0...v2.1
[2.0]: https://github.com/NihlusDuskstalker/gw2chatbufferbuddy/compare/v1.4...v2.0
[1.4]: https://github.com/NihlusDuskstalker/gw2chatbufferbuddy/compare/v1.3...v1.4
[1.3]: https://github.com/NihlusDuskstalker/gw2chatbufferbuddy/compare/v1.2...v1.3
[1.2]: https://github.com/NihlusDuskstalker/gw2chatbufferbuddy/compare/v1.1...v1.2
[1.1]: https://github.com/NihlusDuskstalker/gw2chatbufferbuddy/compare/v1.0...v1.1
