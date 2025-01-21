# import cv2
# from pyzbar.pyzbar import decode
# import os
# import tkinter as tk
# from tkinter import filedialog
# import json
# import os

import cv2
from pyzbar.pyzbar import decode
import json
import os
import sys

def read_qr_from_image(file_path):
    if not os.path.exists(file_path):
        return {"error": "Le fichier n'existe pas."}

    image = cv2.imread(file_path)
    qr_codes = decode(image)

    if not qr_codes:
        return {"info": "Aucun QR Code trouvé."}

    for qr_code in qr_codes:
        qr_data = qr_code.data.decode('utf-8')
        
        # Écrire le code QR dans un fichier JSON si nécessaire
        result_path = os.path.join(os.path.dirname(__file__), 'result.json')
        with open(result_path, 'w') as f:
            json.dump({"scanned_code": qr_data}, f)

        return {"scanned_code": qr_data}

    return {"error": "Aucun QR Code valide trouvé."}

# def read_qr_from_webcam():
#     cap = cv2.VideoCapture(0)

#     if not cap.isOpened():
#         return {"error": "La caméra ne peut pas être ouverte."}

#     while True:
#         ret, frame = cap.read()
#         if not ret:
#             return {"error": "Impossible de capturer l'image."}

#         qr_codes = decode(frame)
#         if qr_codes:
#             for qr_code in qr_codes:
#                 qr_data = qr_code.data.decode('utf-8')
#                 cap.release()
#                 cv2.destroyAllWindows()
#                 return {"scanned_code": qr_data}

#         if cv2.waitKey(1) & 0xFF == ord('q'):
#             break

#     cap.release()
#     cv2.destroyAllWindows()
#     return {"error": "Aucun QR code détecté."}




def read_qr_from_webcam():
    cap = cv2.VideoCapture(0)

    if not cap.isOpened():
        return {"error": "La caméra ne peut pas être ouverte."}

    while True:
        ret, frame = cap.read()
        if not ret:
            break

        qr_codes = decode(frame)
        if qr_codes:
            for qr_code in qr_codes:
                qr_data = qr_code.data.decode('utf-8')
                cap.release()
                return {"scanned_code": qr_data}  # Retourne le code QR trouvé
    
    cap.release()
    return {"error": "Aucun code QR détecté."}





def main():
    if len(sys.argv) > 1 and sys.argv[1] == 'webcam':
        result = read_qr_from_webcam()
    elif len(sys.argv) > 1:
        result = read_qr_from_image(sys.argv[1])
    else:
        result = {"error": "Aucun mode de scan spécifié (webcam ou fichier requis)."}

    # Affiche le résultat en JSON
    print(json.dumps(result))

if __name__ == "__main__":
    main()






# ALOHAN'NY FARANY MANDEHA
# def read_qr_from_image(file_path):
#     if not os.path.exists(file_path):
#         print("Error: Le fichier n'existe pas.")
#         return None

#     image = cv2.imread(file_path)
#     qr_codes = decode(image)

#     if not qr_codes:
#         print("Info: Aucun QR Code trouvé.")
#         return None

#     for qr_code in qr_codes:
#         qr_data = qr_code.data.decode('utf-8')
#         print(f"Donnée du QR Code: {qr_data}")  # Affiche le résultat dans la console
        
#         # Écrire le code QR dans un fichier JSON
#         result_path = os.path.join(os.path.dirname(__file__), 'result.json')
#         if qr_data:
#             with open(result_path, 'w') as f:
#                 json.dump({"scanned_code": qr_data}, f)

#         return qr_data

#     return None

# def read_qr_from_webcam():
#     cap = cv2.VideoCapture(0)

#     if not cap.isOpened():
#         print("Error: La caméra ne peut pas être ouverte.")
#         return None

#     print("Info: Cliquez 's' pour scanner ou 'q' pour quitter.")

#     while True:
#         ret, frame = cap.read()
#         if not ret:
#             print("Error: Impossible de capturer l'image.")
#             break

#         cv2.imshow("Scanner QR Code - Appuyez sur 'q' pour quitter", frame)
#         key = cv2.waitKey(1) & 0xFF
#         if key == ord('s'):
#             qr_codes = decode(frame)
#             if qr_codes:
#                 for qr_code in qr_codes:
#                     qr_data = qr_code.data.decode('utf-8')
#                     print(f"Donnée scannée: {qr_data}")  # Affiche le code scanné

#                     # Écrire le code QR dans un fichier JSON
#                     result_path = os.path.join(os.path.dirname(__file__), 'result.json')
#                     if qr_data:
#                         with open(result_path, 'w') as f:
#                             json.dump({"scanned_code": qr_data}, f)

#                     cap.release()
#                     cv2.destroyAllWindows()
#                     return qr_data  # Retourner le code QR après scan
#             else:
#                 print("Aucun QR code détecté. Essayez encore.")

#         elif key == ord('q'):
#             break

#     cap.release()
#     cv2.destroyAllWindows()
#     return None

# def scan_from_image():
#     file_path = filedialog.askopenfilename(title="Sélectionner un fichier image",
#                                            filetypes=[("Fichiers image", "*.jpg;*.jpeg;*.png;*.jfif")])
#     if file_path:
#         read_qr_from_image(file_path)

# def scan_from_webcam():
#     read_qr_from_webcam()

# def create_button(parent, text, command, bg_color, fg_color):
#     button = tk.Button(parent, text=text, command=command, bg=bg_color, fg=fg_color, 
#                        font=("Roboto", 12), relief='flat', width=25, height=2)
#     # Configurez les coins arrondis en utilisant un canevas
#     rounded_button = tk.Canvas(parent, width=200, height=50, bg=bg_color, highlightthickness=0)
#     rounded_button.create_oval(0, 0, 20, 20, fill=bg_color, outline=bg_color)
#     rounded_button.create_oval(180, 0, 200, 20, fill=bg_color, outline=bg_color)
#     rounded_button.create_rectangle(20, 0, 180, 50, fill=bg_color, outline=bg_color)
#     rounded_button.create_oval(0, 30, 20, 50, fill=bg_color, outline=bg_color)
#     rounded_button.create_oval(180, 30, 200, 50, fill=bg_color, outline=bg_color)
#     rounded_button.create_text(100, 25, text=text, fill=fg_color, font=("Roboto", 12))
#     rounded_button.bind("<Button-1>", lambda event: command())
#     return rounded_button

# def main():
#     # Créez la fenêtre principale
#     root = tk.Tk()
#     root.title("Scanner QR Code")
#     root.geometry("300x150")  

#     # Créez des boutons
#     btn_image = create_button(root, "Importer", scan_from_image, "#4CAF50", "white")
#     btn_image.pack(pady=20)

#     btn_webcam = create_button(root, "Scanner avec Webcam", scan_from_webcam, "#2196F3", "white")
#     btn_webcam.pack(pady=5)

#     # Démarrez la boucle GUI
#     root.mainloop()

# if __name__ == "__main__":
#     main()



# MANDEHA
# # import cv2
# # from pyzbar.pyzbar import decode
# # import os
# # import tkinter as tk
# # from tkinter import filedialog, messagebox

# import cv2
# from pyzbar.pyzbar import decode
# import os
# import tkinter as tk
# from tkinter import filedialog
# import json

# def read_qr_from_image(file_path):
#     if not os.path.exists(file_path):
#         messagebox.showerror("Error", "Le fichier n'existe pas.")
#         return None

#     image = cv2.imread(file_path)
#     qr_codes = decode(image)

#     if not qr_codes:
#         messagebox.showinfo("Info", "Aucun QR Code trouvé.")
#         return None

#     for qr_code in qr_codes:
#         qr_data = qr_code.data.decode('utf-8')
#         messagebox.showinfo("Donnée du QR Code", qr_data)
       
#         if qr_data:
#             with open('result.json', 'w') as f:
#                 json.dump({"scanned_code": qr_data}, f)

#         return qr_data

#     return None

# # def read_qr_from_webcam():
# #     cap = cv2.VideoCapture(0)

# #     if not cap.isOpened():
# #         messagebox.showerror("Error", "Camera ne peut-être ouverte.")
# #         return None

# #     messagebox.showinfo("Info", "Cliquez 'Q' pour quitter.")

# #     while True:
# #         ret, frame = cap.read()
# #         if not ret:
# #             messagebox.showerror("Error", "Impossible de charger l'image.")
# #             break

# #         cv2.imshow("QR Code Scanner - Cliquez 'Q' pour quitter", frame)
# #         key = cv2.waitKey(1) & 0xFF
# #         if key == ord('s'):
# #             qr_codes = decode(frame)
# #             if qr_codes:
# #                 for qr_code in qr_codes:
# #                     qr_data = qr_code.data.decode('utf-8')
# #                     messagebox.showinfo("Donnée du QR Code", qr_data)
# #                     cap.release()
# #                     cv2.destroyAllWindows()
# #                     return qr_data
# #             else:
# #                 messagebox.showinfo("Info", "No QR code detected. Try again.")

# #         elif key == ord('q'):
# #             break

# #     cap.release()
# #     cv2.destroyAllWindows()
# #     return None


# # Modifiez cette partie dans votre script Python
# def read_qr_from_webcam():
#     cap = cv2.VideoCapture(0)

#     if not cap.isOpened():
#         print("Error: Could not open webcam.")
#         return None

#     while True:
#         ret, frame = cap.read()
#         if not ret:
#             print("Error: Failed to capture image.")
#             break

#         cv2.imshow("QR Code Scanner - Press 'q' to quit", frame)
#         key = cv2.waitKey(1) & 0xFF
#         if key == ord('s'):
#             qr_codes = decode(frame)
#             if qr_codes:
#                 for qr_code in qr_codes:
#                     qr_data = qr_code.data.decode('utf-8')
#                     print(qr_data)  # Renvoie le code scanné

#                     if qr_data:
#                         with open('result.json', 'w') as f:
#                             json.dump({"scanned_code": qr_data}, f)

#                     cap.release()
#                     cv2.destroyAllWindows()
#                     return
#             else:
#                 print("No QR code detected. Try again.")

#         elif key == ord('q'):
#             break

#     cap.release()
#     cv2.destroyAllWindows()



# def scan_from_image():
#     file_path = filedialog.askopenfilename(title="Select an Image File",
#                                            filetypes=[("Image Files", "*.jpg;*.jpeg;*.png;*.jfif")])
#     if file_path:
#         read_qr_from_image(file_path)

# def scan_from_webcam():
#     read_qr_from_webcam()

# def create_button(parent, text, command, bg_color, fg_color):
#     button = tk.Button(parent, text=text, command=command, bg=bg_color, fg=fg_color, 
#                        font=("Roboto", 12), relief='flat', width=25, height=2)
#     # Configure rounded corners using a canvas
#     rounded_button = tk.Canvas(parent, width=200, height=50, bg=bg_color, highlightthickness=0)
#     rounded_button.create_oval(0, 0, 20, 20, fill=bg_color, outline=bg_color)
#     rounded_button.create_oval(180, 0, 200, 20, fill=bg_color, outline=bg_color)
#     rounded_button.create_rectangle(20, 0, 180, 50, fill=bg_color, outline=bg_color)
#     rounded_button.create_oval(0, 30, 20, 50, fill=bg_color, outline=bg_color)
#     rounded_button.create_oval(180, 30, 200, 50, fill=bg_color, outline=bg_color)
#     rounded_button.create_text(100, 25, text=text, fill=fg_color, font=("Roboto", 12))
#     rounded_button.bind("<Button-1>", lambda event: command())
#     return rounded_button

# def main():
#     # Create the main window
#     root = tk.Tk()
#     root.title("QR Code Scanner")
#     root.geometry("300x150")  

#     # Create buttons
#     btn_image = create_button(root, "Importer", scan_from_image, "#4CAF50", "white")
#     btn_image.pack(pady=20)

#     btn_webcam = create_button(root, "Scanner avec Webcam", scan_from_webcam, "#2196F3", "white")
#     btn_webcam.pack(pady=5)

#     # Start the GUI loop
#     root.mainloop()
#     pass


# if __name__ == "__main__":
#     main()
#     try:
#         # Ajoutez votre logique ici
#         read_qr_from_webcam()
#     except Exception as e:
#         print(f"Error: {str(e)}") 