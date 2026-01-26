"""Reusable UI components for the patient app."""

import tkinter as tk


def create_keypad(parent: tk.Frame, append_digit, clear_input, delete_last):
    keypad_frame = tk.Frame(parent, bg="#ffffff")
    keypad_frame.pack(pady=5, fill=tk.BOTH, expand=True)

    buttons: list[tk.Button] = []
    keypad_rows = [
        ["1", "2", "3", "4", "5"],
        ["6", "7", "8", "9", "0"],
        ["Q", "W", "E", "R", "T"],
        ["Y", "U", "I", "O", "P"],
        ["A", "S", "D", "F", "G"],
        ["H", "J", "K", "L", "-"],
        ["Z", "X", "C", "V", "B"],
        ["N", "M", "Clear", "Del", ""],
    ]

    for row_index, row in enumerate(keypad_rows):
        for col_index, label in enumerate(row):
            if not label:
                continue
            is_action = label in {"Clear", "Del"}
            bg_color = "#fca5a5" if label == "Clear" else "#fdba74" if label == "Del" else "#e5e7eb"
            button = tk.Button(
                keypad_frame,
                text=label,
                width=6,
                height=2,
                font=("Helvetica", 12, "bold"),
                bg=bg_color,
                fg="#111827",
                command=(lambda l=label, action=is_action: append_digit(l) if not action else (clear_input() if l == "Clear" else delete_last())),
            )
            button.grid(row=row_index, column=col_index, padx=4, pady=4, sticky="nsew")
            buttons.append(button)

    for column_index in range(5):
        keypad_frame.grid_columnconfigure(column_index, weight=1)

    return buttons


def create_action_buttons(parent: tk.Frame, on_bpjs, on_sep):
    action_frame = tk.Frame(parent, bg="#ffffff")
    action_frame.pack(pady=16, fill=tk.BOTH, expand=True)
    action_frame.columnconfigure(0, weight=1)

    button_opts = {
        "font": ("Helvetica", 14, "bold"),
        "height": 3,
        "anchor": "center",
        "fg": "#0b0f1a",
        "activeforeground": "#0b0f1a",
    }

    bpjs_button = tk.Button(
        action_frame, text="Fingerprint BPJS", bg="#22c55e", command=on_bpjs, **button_opts, width=1
    )
    bpjs_button.grid(row=0, column=0, padx=8, pady=6, sticky="ew")

    sep_button = tk.Button(action_frame, text="Cetak SEP", bg="#3b82f6", command=on_sep, **button_opts, width=1)
    sep_button.grid(row=1, column=0, padx=8, pady=10, sticky="ew")
    return bpjs_button, sep_button
