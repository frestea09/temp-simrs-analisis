"""Reusable UI components for the patient app."""

import tkinter as tk


def create_keypad(parent: tk.Frame, append_digit, clear_input, delete_last):
    keypad_frame = tk.Frame(parent, bg="#ffffff")
    keypad_frame.pack(pady=5, fill=tk.BOTH, expand=True)

    buttons: list[tk.Button] = []
    keypad_layout = [
        ("1", append_digit),
        ("2", append_digit),
        ("3", append_digit),
        ("4", append_digit),
        ("5", append_digit),
        ("6", append_digit),
        ("7", append_digit),
        ("8", append_digit),
        ("9", append_digit),
        ("Clear", clear_input),
        ("0", append_digit),
        ("Del", delete_last),
    ]

    for index, (label, handler) in enumerate(keypad_layout):
        is_action = label in {"Clear", "Del"}
        bg_color = "#fca5a5" if label == "Clear" else "#fdba74" if label == "Del" else "#e5e7eb"
        button = tk.Button(
            keypad_frame,
            text=label,
            width=8,
            height=2,
            font=("Helvetica", 13, "bold"),
            bg=bg_color,
            fg="#111827",
            command=(lambda l=label, h=handler, action=is_action: h(l) if not action else h()),
        )
        button.grid(row=index // 3, column=index % 3, padx=4, pady=4, sticky="nsew")
        buttons.append(button)

    for column_index in range(3):
        keypad_frame.grid_columnconfigure(column_index, weight=1)

    return buttons


def create_action_buttons(parent: tk.Frame, on_bpjs, on_sep, on_ticket):
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

    ticket_button = tk.Button(action_frame, text="Cetak Tiket", bg="#f59e0b", command=on_ticket, **button_opts, width=1)
    ticket_button.grid(row=2, column=0, padx=8, pady=6, sticky="ew")

    return bpjs_button, sep_button, ticket_button
