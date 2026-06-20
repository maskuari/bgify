#!/usr/bin/env python3
"""Remove an image background with rembg and save a transparent PNG."""

from pathlib import Path
import sys

from PIL import Image
from rembg import remove


def main() -> int:
    if len(sys.argv) != 3:
        print("Usage: remove_background.py <input_path> <output_path>", file=sys.stderr)
        return 2

    input_path = Path(sys.argv[1])
    output_path = Path(sys.argv[2])

    if not input_path.exists():
        print(f"Input file not found: {input_path}", file=sys.stderr)
        return 2

    output_path.parent.mkdir(parents=True, exist_ok=True)

    with Image.open(input_path) as image:
        image = image.convert("RGBA")
        result = remove(image)
        result.save(output_path, "PNG", optimize=True)

    return 0


if __name__ == "__main__":
    raise SystemExit(main())
