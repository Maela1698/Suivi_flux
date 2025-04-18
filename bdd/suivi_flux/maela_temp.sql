ALTER TABLE public.section_compliance ALTER COLUMN etat SET DEFAULT TRUE;

ALTER TABLE public.section_compliance ADD CONSTRAINT section_compliance_listeemploye_fk FOREIGN KEY (resp_id) REFERENCES public.listeemploye(id);
