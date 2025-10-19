import { handleFetchRequest } from "@/app/api/handleFetchRequest";
import GeneralButton from "@/app/components/common/generalButton/GeneralButton";
import GeneralInput from "@/app/components/common/generalInput/GeneralInput";
import ThanksMessage from "@/app/components/common/thanksMessage/ThanksMessage";
import useGeneralPopUp from "@/app/store/useGeneralPopUp";
import { useMutation } from "@tanstack/react-query";
import clsx from "clsx";
import { Form, Formik } from "formik";
import { useTranslations } from "next-intl";
import React, { useState } from "react";
import * as Yup from "yup";

type Props = {
    customClass?: string;
    project_id?: number;
};

const validationSchema = Yup.object({
    name: Yup.string().min(2, "Name must be at least 2 characters").required("Name is required"),
    email: Yup.string().email("Invalid email").required("Email is required"),
    mobile: Yup.string().min(10, "Mobile number is too short").required("Mobile is required"),
    message: Yup.string().min(10, "Message is too short").max(500, "Message is too long").required("Message is required"),
});

const GeneralForm: React.FC<Props> = ({ customClass, project_id }) => {
    const [serverError, setServerError] = useState<string | null>(null);
    const setChildren = useGeneralPopUp((state) => state.setChildren);
    const  t  = useTranslations();
    const mutation = useMutation({
        mutationFn: (values: any) => {           
            return handleFetchRequest("/contact_messages/request", "POST", { ...values, project_id })
        },
    });

    return (
        <>
            <ThanksMessage isSuccess={mutation.isSuccess} />

            <Formik
                initialValues={{
                    email: "",
                    message: "",
                    country_code: "",
                    project_id: 1,
                    mobile: "",
                    name: "",
                }}
                validationSchema={validationSchema}
                onSubmit={(values, { resetForm, setErrors }) => {
                    setServerError(null);
                    values.mobile = `${values.mobile}`;
                    mutation.mutate(values, {
                        onSuccess: () => {
                            resetForm();
                            setChildren(null, "");
                        },
                        onError: (error: any) => {
                            // Handle server validation errors
                            const backendErrors = error?.response?.data?.data?.errors;
                            if (backendErrors) {
                                const formikErrors: Record<string, string> = {};
                                for (const key in backendErrors) {
                                    formikErrors[key] = backendErrors[key][0]; // Take first error message
                                }
                                setErrors(formikErrors);
                            } else {
                                // Handle general server errors
                                setServerError(error?.response?.data?.message || "An error occurred. Please try again.");
                            }
                        },
                    });
                }}
            >
                {(formik) => (
                    <Form className={clsx("w-full grid grid-cols-1 gap-8", customClass)}>
                        {serverError && (
                            <div className="text-red-600 bg-red-100 border border-red-300 p-3 rounded-md text-center">
                                {serverError}
                            </div>
                        )}

                        <GeneralInput name="name" placeholder={t("form.name")} customClass="!h-15 bg-white col-span-full" />
                        <GeneralInput name="email" placeholder={t("form.email")} customClass="!h-15 bg-white col-span-full" />

                        <GeneralInput
                            name="mobile"
                            isPhone
                            value={formik.values.mobile}
                            defaultCountry="SA"
                            onPhoneChange={({ countryCode, phoneNumber }) => {
                                formik.setFieldValue("country_code", countryCode);
                                formik.setFieldValue("mobile", phoneNumber);
                            }}
                            customClass="!h-15 bg-white col-span-full"
                        />

                        <GeneralInput as="textarea" name="message" placeholder={t("form.message")} customClass="!h-15 bg-white col-span-full" />

                        <GeneralButton
                            title={t("form.submit")}
                            customClass="col-span-full"
                            isBlack
                            isPillEffect
                            type="submit"
                            disabled={mutation.isPending}
                        />
                    </Form>
                )}
            </Formik>
        </>
    );
};

export default GeneralForm;
