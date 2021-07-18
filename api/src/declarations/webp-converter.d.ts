// note: this only contains some of the methods available, consider looking at the documentation for webp-converter

declare module 'webp-converter' {
    // Converts a png, jpg, tiff or webp image to a webp image
    export function cwebp (sourceImage: string, targetFile: string, options?: string, extrapath?: string): Promise<string>

    // converts a buffer to a webp buffer
    export function buffer2webpbuffer (buffer: Buffer, imageType: 'jpg' | 'png' | 'tiff' | 'webp' | "y'cbcr", options?: string, extraPath?: string): Promise<Buffer>

    // converts a gif to an animated webp file
    export function gwebp (sourceImage: string, destinationFile: string, options?: string): Promise<string>

  // this will grant 755 permission to webp executables
  export function grant_permission(): void
}
