/*
  A collection of escape characters for styling logs in the terminal.
  To apply simply concat the values with the string and everything after it gets styled.
*/
export const LogStyle = {
  // Resets the styling
  reset: "\x1b[0m",
  // Makes the font bold and changes the font color to a lighter color in supported terminals
  bright: "\x1b[1m",
  // Makes the font color slightly darker in supported terminals
  dim: "\x1b[2m",
  // Underscores the text
  underscore: "\x1b[4m",
  // Makes the text blink on supported terminals
  blink: "\x1b[5m",
  // Changes the text color to the background color and the background color to the text color
  reverse: "\x1b[7m",
  // Hides text however background is unaffected
  hidden: "\x1b[8m",
  // Foreground (text) colors
  fg: {
    black: "\x1b[30m",
    red: "\x1b[31m",
    green: "\x1b[32m",
    yellow: "\x1b[33m",
    blue: "\x1b[34m",
    magenta: "\x1b[35m",
    cyan: "\x1b[36m",
    white: "\x1b[37m",
    crimson: "\x1b[38m"
  },
  // Background colors
  bg: {
    black: "\x1b[40m",
    red: "\x1b[41m",
    green: "\x1b[42m",
    yellow: "\x1b[43m",
    blue: "\x1b[44m",
    magenta: "\x1b[45m",
    cyan: "\x1b[46m",
    white: "\x1b[47m",
    crimson: "\x1b[48m"
  }
};
