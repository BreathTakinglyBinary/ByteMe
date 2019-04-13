This plugin will provide some protection against malicious players who try to crash your server using input in signs and books.

## Summary
The plugin checks to see if the character input is within the allowed maximum and doesn't exceed storage size limits.  The following actions are taken when bad input is detected.

> - Sign and Book Text is cleared.
> - Signs are removed.
> - Player that is trying to input bad text is banned.

## Configuration

The maximum number of characters to allow on a sign or in a book. When checking a book, this will be applied per page. The default is 1000. Which accounts for the possibility of a max of 59 characters per line with 1 text format on each character when dealing with signs.

`max-character-limit: 1000`

Setting ban-violators to true, will automatically ban players who try to create signs, or pages in books, that exceed the max-character-limit.  When this happens, a message will be logged in the server log that shows the player who was banned and the text that was considered in violation.

`ban-violators: true`

When set to true, signs that exceed the character limit will be removed.

`remove-bad-signs: true`

Set to true to check updates made to writable books.

`check-book-updates: true`

## Sign Test Case
This was the text used to determine maximum viewable characters on a sign with formatting.  There are 59 visible characters per line.  Each character has 1 text format code with it. When counting a new-line character at the end of all 4 lines, this comes to about 712 character.  The maximum was set to allow for this to be reached with a little head room, but still doesn't allow signs (or other imput) that cause players or servers to crash.
```
§1ǀ§2ǀ§3ǀ§4ǀ§5ǀ§6ǀ§7ǀ§8ǀ§9ǀ§aǀ§bǀ§cǀ§dǀ§eǀ§fǀ§1ǀ§2ǀ§3ǀ§4ǀ§5ǀ§6ǀ§7ǀ§8ǀ§9ǀ§aǀ§bǀ§cǀ§dǀ§eǀ§fǀ§1ǀ§2ǀ§3ǀ§4ǀ§5ǀ§6ǀ§7ǀ§8ǀ§9ǀ§aǀ§bǀ§cǀ§dǀ§eǀ§fǀ§1ǀ§2ǀ§3ǀ§4ǀ§5ǀ§6ǀ§7ǀ§8ǀ§9ǀ§aǀ§bǀ§cǀ§dǀ§eǀ
§1ǀ§2ǀ§3ǀ§4ǀ§5ǀ§6ǀ§7ǀ§8ǀ§9ǀ§aǀ§bǀ§cǀ§dǀ§eǀ§fǀ§1ǀ§2ǀ§3ǀ§4ǀ§5ǀ§6ǀ§7ǀ§8ǀ§9ǀ§aǀ§bǀ§cǀ§dǀ§eǀ§fǀ§1ǀ§2ǀ§3ǀ§4ǀ§5ǀ§6ǀ§7ǀ§8ǀ§9ǀ§aǀ§bǀ§cǀ§dǀ§eǀ§fǀ§1ǀ§2ǀ§3ǀ§4ǀ§5ǀ§6ǀ§7ǀ§8ǀ§9ǀ§aǀ§bǀ§cǀ§dǀ§eǀ
§1ǀ§2ǀ§3ǀ§4ǀ§5ǀ§6ǀ§7ǀ§8ǀ§9ǀ§aǀ§bǀ§cǀ§dǀ§eǀ§fǀ§1ǀ§2ǀ§3ǀ§4ǀ§5ǀ§6ǀ§7ǀ§8ǀ§9ǀ§aǀ§bǀ§cǀ§dǀ§eǀ§fǀ§1ǀ§2ǀ§3ǀ§4ǀ§5ǀ§6ǀ§7ǀ§8ǀ§9ǀ§aǀ§bǀ§cǀ§dǀ§eǀ§fǀ§1ǀ§2ǀ§3ǀ§4ǀ§5ǀ§6ǀ§7ǀ§8ǀ§9ǀ§aǀ§bǀ§cǀ§dǀ§eǀ
§1ǀ§2ǀ§3ǀ§4ǀ§5ǀ§6ǀ§7ǀ§8ǀ§9ǀ§aǀ§bǀ§cǀ§dǀ§eǀ§fǀ§1ǀ§2ǀ§3ǀ§4ǀ§5ǀ§6ǀ§7ǀ§8ǀ§9ǀ§aǀ§bǀ§cǀ§dǀ§eǀ§fǀ§1ǀ§2ǀ§3ǀ§4ǀ§5ǀ§6ǀ§7ǀ§8ǀ§9ǀ§aǀ§bǀ§cǀ§dǀ§eǀ§fǀ§1ǀ§2ǀ§3ǀ§4ǀ§5ǀ§6ǀ§7ǀ§8ǀ§9ǀ§aǀ§bǀ§cǀ§dǀ§eǀ
```

